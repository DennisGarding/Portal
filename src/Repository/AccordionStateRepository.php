<?php

namespace App\Repository;

use App\Entity\AccordionState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AccordionState>
 */
class AccordionStateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccordionState::class);
    }

    public function save(AccordionState $accordionState): void
    {
        $this->getEntityManager()->persist($accordionState);
        $this->getEntityManager()->flush();
    }
}
