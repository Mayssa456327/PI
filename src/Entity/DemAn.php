<?php

namespace App\Entity;

use App\Repository\DemAnRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemAnRepository::class)]
class DemAn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $NomP = null;

    #[ORM\Column(length: 8)]
    private ?string $IDP = null;

    #[ORM\Column(length: 20)]
    private ?string $NomM = null;

    #[ORM\ManyToOne(inversedBy: 'a')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $Type = null;

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

    public function getIDP(): ?string
    {
        return $this->IDP;
    }

    public function setIDP(string $IDP): static
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

    public function getType(): ?Type
    {
        return $this->Type;
    }

    public function setType(?Type $Type): static
    {
        $this->Type = $Type;

        return $this;
    }
}
