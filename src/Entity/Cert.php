<?php

namespace App\Entity;

use App\Repository\CertRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: CertRepository::class)]
class Cert
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

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern:"/\d{4}-\d{2}-\d{2}/",
        message:"Le format de la date doit être YYYY-MM-DD."
    )]
    private ?string $Date = null;

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

    public function getDate(): ?string
    {
        return $this->Date;
    }

    public function setDate(string $Date): static
    {
        $this->Date = $Date;

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
