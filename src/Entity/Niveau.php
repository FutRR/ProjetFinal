<?php

namespace App\Entity;

use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NiveauRepository::class)]
class Niveau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomNiveau = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Etape>
     */
    #[ORM\OneToMany(targetEntity: Etape::class, mappedBy: 'Niveau')]
    private Collection $Etapes;

    public function __construct()
    {
        $this->Etapes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomNiveau(): ?string
    {
        return $this->nomNiveau;
    }

    public function setNomNiveau(string $nomNiveau): static
    {
        $this->nomNiveau = $nomNiveau;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Etape>
     */
    public function getEtapes(): Collection
    {
        return $this->Etapes;
    }

    public function addEtape(Etape $etape): static
    {
        if (!$this->Etapes->contains($etape)) {
            $this->Etapes->add($etape);
            $etape->setNiveau($this);
        }

        return $this;
    }

    public function removeEtape(Etape $etape): static
    {
        if ($this->Etapes->removeElement($etape)) {
            // set the owning side to null (unless already changed)
            if ($etape->getNiveau() === $this) {
                $etape->setNiveau(null);
            }
        }

        return $this;
    }
}
