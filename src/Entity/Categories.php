<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Category = null;

    #[ORM\Column(length: 255)]
    private ?string $icone_url = null;

    #[ORM\Column(nullable: true)]
    private ?int $color = null;

    #[ORM\ManyToMany(targetEntity: Formations::class, mappedBy: 'categories')]
    private Collection $formations;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->Category;
    }

    public function setCategory(string $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    public function getIconeUrl(): ?string
    {
        return $this->icone_url;
    }

    public function setIconeUrl(string $icone_url): self
    {
        $this->icone_url = $icone_url;

        return $this;
    }

    public function getColor(): ?int
    {
        return $this->color;
    }

    public function setColor(?int $color): self
    {
        $this->color = $color;

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
            $formation->addCategory($this);
        }

        return $this;
    }

    public function removeFormation(Formations $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            $formation->removeCategory($this);
        }

        return $this;
    }
}
