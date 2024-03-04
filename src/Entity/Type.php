<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    private ?string $Nom = null;

    #[ORM\OneToMany(targetEntity: DemAn::class, mappedBy: 'Type')]
    private Collection $a;

    public function __construct()
    {
        $this->a = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }
    public function __toString()
    {
        // Remplacez 'name' par le nom de la propriété que vous souhaitez utiliser pour représenter cet objet sous forme de chaîne.
        return $this->Nom;
    }
    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    /**
     * @return Collection<int, DemAn>
     */
    public function getA(): Collection
    {
        return $this->a;
    }

    public function addA(DemAn $a): static
    {
        if (!$this->a->contains($a)) {
            $this->a->add($a);
            $a->setType($this);
        }

        return $this;
    }

    public function removeA(DemAn $a): static
    {
        if ($this->a->removeElement($a)) {
            // set the owning side to null (unless already changed)
            if ($a->getType() === $this) {
                $a->setType(null);
            }
        }

        return $this;
    }
}
