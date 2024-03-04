<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de l'hôpital est requis.")]

    private ?string $nomPatient = null;

    #[ORM\Column(type:"date",nullable:true)]
    #[Assert\GreaterThanOrEqual("today", message: "La date de début doit être supérieure ou égale à aujourd'hui.")]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type:"date",nullable:true)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hopital $Hopital = null;

    #[ORM\OneToMany(targetEntity: Chambre::class, mappedBy: 'reservation')]
    private Collection $chambre;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'email de l'utilisateur est requis.")]

    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $Telephone = null;

    public function __construct()
    {
        $this->chambre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPatient(): ?string
    {
        return $this->nomPatient;
    }

    public function setNomPatient(string $nomPatient): static
    {
        $this->nomPatient = $nomPatient;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getHopital(): ?Hopital
    {
        return $this->Hopital;
    }

    public function setHopital(?Hopital $Hopital): static
    {
        $this->Hopital = $Hopital;

        return $this;
    }

    /**
     * @return Collection<int, Chambre>
     */
    public function getChambre(): Collection
    {
        return $this->chambre;
    }

    public function addChambre(Chambre $chambre): static
    {
        if (!$this->chambre->contains($chambre)) {
            $this->chambre->add($chambre);
            $chambre->setReservation($this);
        }

        return $this;
    }

    public function removeChambre(Chambre $chambre): static
    {
        if ($this->chambre->removeElement($chambre)) {
            // set the owning side to null (unless already changed)
            if ($chambre->getReservation() === $this) {
                $chambre->setReservation(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->Telephone;
    }

    public function setTelephone(string $Telephone): static
    {
        $this->Telephone = $Telephone;

        return $this;
    }
}
