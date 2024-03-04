<?php

namespace App\Entity;

use App\Repository\SponsorRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SponsorRepository::class)]

class Sponsor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:5)]
    #[Assert\Length(max:100)]
    #[Assert\NotBlank (message:"veuillez saisir le nom de sponsor ")]
    private ?string $nomSponsor = null;

   
    #[ORM\Column(length: 180)]
    #[Assert\Email()]
    private ?string $emailSponsor = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:3)]
    #[Assert\Length(max:3)]
    #[Assert\NotBlank (message:"veuillez saisir le budge de sponsor ")]
    private ?float $budget = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:5)]
    #[Assert\Length(max:200)]
    #[Assert\NotBlank (message:"veuillez saisir l'adresse de sponsor ")]
    private ?string $adresse = null;

    #[ORM\ManyToOne(inversedBy: 'Sponsor')]
    private ?Evenement $Evenement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSponsor(): ?string
    {
        return $this->nomSponsor;
    }

    public function setNomSponsor(string $nomSponsor): static
    {
        $this->nomSponsor = $nomSponsor;

        return $this;
    }

    public function getEmailSponsor(): ?string
    {
        return $this->emailSponsor;
    }

    public function setEmailSponsor(string $emailSponsor): static
    {
        $this->emailSponsor = $emailSponsor;

        return $this;
    }

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(float $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->Evenement;
    }

    public function setEvenement(?Evenement $Evenement): static
    {
        $this->Evenement = $Evenement;

        return $this;
    }
}
