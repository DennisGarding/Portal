<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\Exceptions\CategoryRepositoryException;
use App\Validator\AbstractValidator;
use App\Validator\CategoryValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly CategoryValidator  $categoryValidator,
    )
    {
    }

    #[Route('/call/category/load', name: 'call_category_load_all', methods: ['GET'])]
    public function loadAll()
    {
        $categoryList = $this->categoryRepository->findAll();

        return $this->json($categoryList);
    }

    #[Route('/call/category/load/{categoryId}', name: 'call_category_load', methods: ['GET'])]
    public function load(string $categoryId): JsonResponse
    {
        $category = $this->categoryRepository->find($categoryId);
        if (!$category instanceof Category) {
            return $this->json(
                ['error' => \sprintf('Category by id: "%s" not found', $categoryId)],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->json($category);
    }

    #[Route('/call/category/load/by/{type}', name: 'call_category_load_by_type', methods: ['GET'])]
    public function loadByType(string $type): JsonResponse
    {
        $category = $this->categoryRepository->loadByType($type);

        return $this->json($category);
    }

    #[Route('/call/category/{method}', name: 'call_category_create_update', methods: ['POST'])]
    public function save(string $method, Request $request): JsonResponse
    {
        $categoryData = json_decode($request->getContent(), true);
        $validation = $this->categoryValidator->validate($categoryData, $method);

        if ($validation !== null) {
            return $this->json(
                ['error' => $validation],
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $link = match ($method) {
                AbstractValidator::METHOD_CREATE => $this->categoryRepository->create($categoryData),
                AbstractValidator::METHOD_UPDATE => $this->categoryRepository->update($categoryData),
                default => null,
            };
        } catch (CategoryRepositoryException $e) {
            return $this->json(
                ['error' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->json($link);
    }

    #[Route('/call/category/delete/{categoryId}', name: 'call_category_delete', methods: ['DELETE'])]
    public function delete(string $categoryId): JsonResponse
    {
        $category = $this->categoryRepository->find($categoryId);
        if (!$category instanceof Category) {
            return $this->json(
                ['error' => \sprintf('Category by id: "%s" not found', $categoryId)],
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $this->categoryRepository->delete($category);
        } catch (\Throwable $e) {
            return $this->json(
                ['error' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }


        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
