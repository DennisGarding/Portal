<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Link;
use App\Repository\Exceptions\LinkRepositoryException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Link>
 */
class LinkRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry                     $registry,
        private readonly CategoryRepository $categoryRepository,

    )
    {
        parent::__construct($registry, Link::class);
    }

    public function create(array $linkData): Link
    {
        $category = $this->categoryRepository->find($linkData['categoryId']);
        if ($category instanceof Category === false) {
            throw new LinkRepositoryException('Category not found');
        }

        $link = new Link();
        $link->setName($linkData['name']);
        $link->setUrl($linkData['url']);
        $link->setCategory($category);

        $this->getEntityManager()->persist($link);
        $this->getEntityManager()->flush();

        return $link;
    }

    public function update(array $linkData): Link
    {
        $category = $this->categoryRepository->find($linkData['categoryId']);
        if ($category instanceof Category === false) {
            throw new LinkRepositoryException('Category not found: ID: ' . $linkData['categoryId']);
        }

        $link = $this->find($linkData['id']);
        if ($link instanceof Category) {
            throw new LinkRepositoryException('Link not found: ID: ' . $linkData['id']);
        }
        $link->setName($linkData['name']);
        $link->setUrl($linkData['url']);
        $link->setCategory($category);

        $this->getEntityManager()->persist($link);
        $this->getEntityManager()->flush();

        return $link;
    }

    public function move(array $linkData): Link
    {
        $category = $this->categoryRepository->find($linkData['categoryId']);
        if ($category instanceof Category === false) {
            throw new LinkRepositoryException('Category not found');
        }

        $link = $this->find($linkData['id']);
        if ($link instanceof Link === false) {
            throw new LinkRepositoryException('Link not found');
        }

        $link->setCategory($category);

        $this->getEntityManager()->persist($link);
        $this->getEntityManager()->flush();

        return $link;
    }

    public function delete(Link $link): void
    {
        $this->getEntityManager()->remove($link);
        $this->getEntityManager()->flush();
    }
}
