<?php

namespace App\Entity;

use App\Repository\HopitalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HopitalRepository::class)]
class Hopital
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le nom de l'hôpital est requis.")]
    private ?string $Nom = null;


    #[Assert\NotBlank(message:"L'adresse de l'hôpital est requis.")]
    #[ORM\Column(length: 255)]
    private ?string $Adresse = null;


    #[Assert\NotBlank(message:"Le telephone de l'hôpital est requis.")]
    #[ORM\Column(length: 20)]
    private ?string $Telephone = null;

    #[Assert\NotBlank(message :"L'email de l'hôpital est requis.")]
    #[ORM\Column(length: 255)]
    private ?string $Email = null;

    #[Assert\NotBlank(message: "Le nombre de chambre de l'hôpital est requis.")]
    #[ORM\Column]
    private ?int $NombreChambre = null;

    #[ORM\OneToMany(targetEntity: Chambre::class, mappedBy: 'hopital')]
    private Collection $chambre;

    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'Hopital')]
    private Collection $reservations;

    public function __construct()
    {
        $this->chambre = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): static
    {
        $this->Adresse = $Adresse;

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

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getNombreChambre(): ?int
    {
        return $this->NombreChambre;
    }

    public function setNombreChambre(int $NombreChambre): static
    {
        $this->NombreChambre = $NombreChambre;

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
            $chambre->setHopital($this);
        }

        return $this;
    }

    public function removeChambre(Chambre $chambre): static
    {
        if ($this->chambre->removeElement($chambre)) {
            // set the owning side to null (unless already changed)
            if ($chambre->getHopital() === $this) {
                $chambre->setHopital(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setHopital($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getHopital() === $this) {
                $reservation->setHopital(null);
            }
        }

        return $this;
    }
}
