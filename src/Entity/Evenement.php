<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
 
    #[ORM\Column(length: 255)]
    private  $imageEvenement = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:5)]
    #[Assert\Length(max:20)]
    #[Assert\NotBlank (message:"veuillez saisir le Type de l'evenement ")]
    private ?string $typeEvenement = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:5)]
    #[Assert\Length(max:20)]
    #[Assert\NotBlank (message:"veuillez saisir le nom de l'evenement ")]
    private ?string $nomEvenement = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:5)]
    #[Assert\Length(max:20)]
    #[Assert\NotBlank (message:"veuillez saisir le lieu de l'evenement ")]
    private ?string $lieuEvenement = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank (message:"veuillez saisir le Date Debut de l'evenement ")]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank (message:"veuillez saisir le Date Fin de l'evenement ")]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column]
    private ?float $budget = null;

    #[ORM\OneToMany(targetEntity: Sponsor::class, mappedBy: 'Evenement')]
    private Collection $Sponsor;


    public function __construct()
    {
        $this->dateDebut = new \DateTime('now');
        $this->dateFin = new \DateTime('now');
        $this->Sponsor = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageEvenement()
    {
        return $this->imageEvenement;
    }

    public function setImageEvenement( $imageEvenement)
    {
        $this->imageEvenement = $imageEvenement;

        return $this;
    }

    public function getTypeEvenement(): ?string
    {
        return $this->typeEvenement;
    }

    public function setTypeEvenement(string $typeEvenement): static
    {
        $this->typeEvenement = $typeEvenement;

        return $this;
    }

    public function getNomEvenement(): ?string
    {
        return $this->nomEvenement;
    }

    public function setNomEvenement(string $nomEvenement): static
    {
        $this->nomEvenement = $nomEvenement;

        return $this;
    }

    public function getLieuEvenement(): ?string
    {
        return $this->lieuEvenement;
    }

    public function setLieuEvenement(string $lieuEvenement): static
    {
        $this->lieuEvenement = $lieuEvenement;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }


    public function __toString()
    {
        return $this->nomEvenement;
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

    /**
     * @return Collection<int, Sponsor>
     */
    public function getSponsor(): Collection
    {
        return $this->Sponsor;
    }

    public function addSponsor(Sponsor $sponsor): static
    {
        if (!$this->Sponsor->contains($sponsor)) {
            $this->Sponsor->add($sponsor);
            $sponsor->setEvenement($this);
        }

        return $this;
    }

    public function removeSponsor(Sponsor $sponsor): static
    {
        if ($this->Sponsor->removeElement($sponsor)) {
            // set the owning side to null (unless already changed)
            if ($sponsor->getEvenement() === $this) {
                $sponsor->setEvenement(null);
            }
        }

        return $this;
    }
}
