<?php

namespace App\Controller;

use App\Repository\LinkCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class LinkCategoryController extends AbstractController
{
    #[Route('/api/link/category/create', name: 'api_link_category_create', methods: ['POST'])]
    public function createLinkCategory(Request $request, LinkCategoryRepository $linkCategoryRepository): JsonResponse
    {
        $categoryDataArray = json_decode($request->getContent(), true);

        $violations = Validation::createValidator()->validate($categoryDataArray, $this->getCreateConstraints());

        if ($violations->count() > 0) {
            $violationMessages = [];
            foreach ($violations as $violation) {
                $violationMessages[] = $violation->getMessage();
            }

            return $this->json(
                ['error' => $violationMessages],
                Response::HTTP_BAD_REQUEST
            );
        }

        $linkCategory = $linkCategoryRepository->create($categoryDataArray['name']);

        return $this->json(
            $linkCategory,
        );
    }

    private function getCreateConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'name' => [
                new Assert\NotBlank(),
                new Assert\Type('string'),
                new Assert\Length(['min' => 1, 'max' => 255]),
            ],
        ]);
    }
}