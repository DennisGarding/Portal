<?php

namespace App\Repository;

use App\Entity\LinkCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LinkCategory>
 */
class LinkCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LinkCategory::class);
    }

    public function create(string $name): LinkCategory
    {
        $linkCategory = new LinkCategory();
        $linkCategory->setName($name);

        $entityManager = $this->getEntityManager();

        $entityManager->persist($linkCategory);
        $entityManager->flush();

        return $linkCategory;
    }

    public function save(int $id, string $name): LinkCategory
    {
        $linkCategory = $this->find($id);
        $linkCategory->setName($name);

        $entityManager = $this->getEntityManager();
        $entityManager->persist($linkCategory);
        $entityManager->flush();

        return $linkCategory;
    }
}
