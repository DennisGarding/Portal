<?php

namespace App\Entity;

use App\Repository\AccordionStateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccordionStateRepository::class)]
class AccordionState
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private array $state = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getState(): array
    {
        return $this->state;
    }

    public function setState(array $state): static
    {
        $this->state = $state;

        return $this;
    }
}
