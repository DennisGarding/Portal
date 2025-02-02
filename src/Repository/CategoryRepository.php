<?php

namespace App\Repository;

use App\Entity\Category;
use App\Repository\Exceptions\CategoryRepositoryException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);

        $this->entityManager = $this->getEntityManager();
    }

    /**
     * @return array<Category>
     */
    public function loadByType(string $type): array
    {
        return $this->findBy(['type' => $type]);
    }

    public function create(array $data): Category
    {
        $category = new Category();
        $category->setName($data['name']);
        $category->setType($data['type']);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category;
    }

    public function update(array $data): Category
    {
        $category = $this->find($data['id']);
        if (!$category instanceof Category) {
            throw new CategoryRepositoryException('Category not found for update');
        }

        $category->setName($data['name']);
        $category->setType($data['type']);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category;
    }

    public function delete(Category $category): void
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush();
    }
}
