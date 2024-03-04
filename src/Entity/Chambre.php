<?php

namespace App\Entity;

use App\Repository\ChambreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChambreRepository::class)]
class Chambre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Numero = null;

    #[ORM\Column]
    private ?bool $Diponibiliter = null;

    #[ORM\Column]
    private ?int $NombreLit = null;

    #[ORM\ManyToOne(inversedBy: 'chambre')]
    private ?Hopital $hopital = null;

    #[ORM\ManyToOne(inversedBy: 'chambre')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reservation $reservation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->Numero;
    }

    public function setNumero(int $Numero): static
    {
        $this->Numero = $Numero;

        return $this;
    }

    public function isDiponibiliter(): ?bool
    {
        return $this->Diponibiliter;
    }

    public function setDiponibiliter(bool $Diponibiliter): static
    {
        $this->Diponibiliter = $Diponibiliter;

        return $this;
    }

    public function getNombreLit(): ?int
    {
        return $this->NombreLit;
    }

    public function setNombreLit(int $NombreLit): static
    {
        $this->NombreLit = $NombreLit;

        return $this;
    }

    public function getHopital(): ?Hopital
    {
        return $this->hopital;
    }

    public function setHopital(?Hopital $hopital): static
    {
        $this->hopital = $hopital;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): static
    {
        $this->reservation = $reservation;

        return $this;
    }
}
