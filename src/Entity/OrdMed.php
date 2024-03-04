<?php

namespace App\Entity;

use App\Repository\OrdMedRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdMedRepository::class)]
class OrdMed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    private ?string $NomP = null;

    #[ORM\Column]
    private ?int $IDP = null;

    #[ORM\Column(length: 15)]
    private ?string $NomM = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomP(): ?string
    {
        return $this->NomP;
    }

    public function setNomP(string $NomP): static
    {
        $this->NomP = $NomP;

        return $this;
    }

    public function getIDP(): ?int
    {
        return $this->IDP;
    }

    public function setIDP(int $IDP): static
    {
        $this->IDP = $IDP;

        return $this;
    }

    public function getNomM(): ?string
    {
        return $this->NomM;
    }

    public function setNomM(string $NomM): static
    {
        $this->NomM = $NomM;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }
}
