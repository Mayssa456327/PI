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
    #[Assert\NotBlank (message:"veuillez saisir l'image de l'evenement ")]
    private  $imageEvenement = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:5)]
    #[Assert\Length(max:70)]
    #[Assert\NotBlank (message:"veuillez saisir le Type de l'evenement ")]
    private ?string $typeEvenement = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:5)]
    #[Assert\Length(max:70)]
    #[Assert\NotBlank (message:"veuillez saisir le nom de l'evenement ")]
    private ?string $nomEvenement = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:5)]
    #[Assert\Length(max:100)]
    #[Assert\NotBlank (message:"veuillez saisir le lieu de l'evenement ")]
    private ?string $lieuEvenement = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank (message:"veuillez saisir le Date Debut de l'evenement ")]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank (message:"veuillez saisir le Date Fin de l'evenement ")]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column]
    #[Assert\Length(min:2)]
    #[Assert\Length(max:3)]
    #[Assert\NotBlank (message:"veuillez saisir le budge de l'evenement ")]
    private ?float $budget = null;

    #[ORM\OneToMany(targetEntity: Sponsor::class, mappedBy: 'Evenement')]
    private Collection $Sponsor;

    #[ORM\OneToMany(mappedBy: 'Evenement', targetEntity: Avis::class)]
    private Collection $avis;


    public function __construct()
    {
        $this->dateDebut = new \DateTime('now');
        $this->dateFin = new \DateTime('now');
        $this->Sponsor = new ArrayCollection();
        $this->avis = new ArrayCollection();
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

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): static
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setEvenement($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): static
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getEvenement() === $this) {
                $avi->setEvenement(null);
            }
        }

        return $this;
    }
}
