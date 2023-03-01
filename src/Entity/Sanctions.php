<?php

namespace App\Entity;

use App\Repository\SanctionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SanctionsRepository::class)]
class Sanctions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Sanction = null;

    #[ORM\OneToMany(mappedBy: 'sanction', targetEntity: Formations::class)]
    private Collection $formations;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSanction(): ?string
    {
        return $this->Sanction;
    }

    public function setSanction(string $Sanction): self
    {
        $this->Sanction = $Sanction;

        return $this;
    }

    /**
     * @return Collection<int, Formations>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formations $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations->add($formation);
            $formation->setSanction($this);
        }

        return $this;
    }

    public function removeFormation(Formations $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getSanction() === $this) {
                $formation->setSanction(null);
            }
        }

        return $this;
    }
}
