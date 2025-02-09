<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Snippet;
use App\Repository\Exceptions\SnippetRepositoryException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Snippet>
 */
class SnippetRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry                     $registry,
        private readonly CategoryRepository $categoryRepository,
    )
    {
        parent::__construct($registry, Snippet::class);
    }

    public function create(array $snippetData): Snippet
    {
        $category = $this->categoryRepository->find($snippetData['categoryId']);
        if ($category instanceof Category === false) {
            throw new SnippetRepositoryException('Category not found: ID: ' . $snippetData['categoryId']);
        }

        $snippet = new Snippet();
        $snippet->setName($snippetData['name']);
        $snippet->setDescription($snippetData['description']);
        $snippet->setType($snippetData['type']);
        $snippet->setCode($snippetData['code']);
        $snippet->setCategory($category);

        $this->getEntityManager()->persist($snippet);
        $this->getEntityManager()->flush();

        return $snippet;
    }

    public function update(array $snippetData): Snippet
    {
        $category = $this->categoryRepository->find($snippetData['categoryId']);
        if ($category instanceof Category === false) {
            throw new SnippetRepositoryException('Category not found: ID: ' . $snippetData['categoryId']);
        }

        $snippet = $this->find($snippetData['id']);
        if ($snippet instanceof Snippet === false) {
            throw new SnippetRepositoryException('Snippet not found: ID: ' . $snippetData['id']);
        }

        $snippet->setName($snippetData['name']);
        $snippet->setDescription($snippetData['description']);
        $snippet->setType($snippetData['type']);
        $snippet->setCode($snippetData['code']);
        $snippet->setCategory($category);

        $this->getEntityManager()->persist($snippet);
        $this->getEntityManager()->flush();

        return $snippet;
    }

    public function delete(Snippet $snippet): void
    {
        $this->getEntityManager()->remove($snippet);
        $this->getEntityManager()->flush();
    }
}
