<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Note;
use App\Repository\Exceptions\NoteRepositoryException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Note>
 */
class NoteRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry                     $registry,
        private readonly CategoryRepository $categoryRepository,
    )
    {
        parent::__construct($registry, Note::class);
    }

    public function create(array $noteData): Note
    {
        $category = $this->categoryRepository->find($noteData['categoryId']);
        if ($category instanceof Category === false) {
            throw new NoteRepositoryException('Category not found: ID: ' . $noteData['categoryId']);
        }

        $note = new Note();
        $note->setName($noteData['name']);
        $note->setNote($noteData['note']);
        $note->setCategory($category);

        $this->getEntityManager()->persist($note);
        $this->getEntityManager()->flush();

        return $note;
    }

    public function update(array $noteData): Note
    {
        $category = $this->categoryRepository->find($noteData['categoryId']);
        if ($category instanceof Category === false) {
            throw new NoteRepositoryException('Category not found: ID: ' . $noteData['categoryId']);
        }

        $note = $this->find($noteData['id']);
        if (!$note instanceof Note) {
            throw new NoteRepositoryException('Note not found: ID: ' . $noteData['id']);
        }

        $note->setName($noteData['name']);
        $note->setNote($noteData['note']);
        $note->setCategory($category);

        $this->getEntityManager()->persist($note);
        $this->getEntityManager()->flush();

        return $note;
    }

    public function delete(Note $note): void
    {
        $this->getEntityManager()->remove($note);
        $this->getEntityManager()->flush();
    }
}
