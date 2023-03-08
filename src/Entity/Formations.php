<?php

namespace App\Entity;

use App\Repository\FormationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormationsRepository::class)]
class Formations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'formations')]
    private ?Sanctions $sanction = null;

    #[ORM\ManyToMany(targetEntity: Categories::class, inversedBy: 'formations')]
    private Collection $categories;

    #[ORM\ManyToOne(inversedBy: 'formations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Universities $university = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $generality = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $prerequisite = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $purpose = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $finality = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contents = null;

    #[ORM\Column(nullable: true)]
    private ?int $prices = null;

    #[ORM\Column(length: 255)]
    private ?string $duration = null;

    #[ORM\Column]
    private ?bool $priority = null;

    #[ORM\Column(length: 255)]
    private ?string $vignette_url = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSanction(): ?Sanctions
    {
        return $this->sanction;
    }

    public function setSanction(?Sanctions $sanction): self
    {
        $this->sanction = $sanction;

        return $this;
    }

    /**
     * @return Collection<int, Categories>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categories $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Categories $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getUniversity(): ?Universities
    {
        return $this->university;
    }

    public function setUniversity(?Universities $university): self
    {
        $this->university = $university;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getGenerality(): ?string
    {
        return $this->generality;
    }

    public function setGenerality(string $generality): self
    {
        $this->generality = $generality;

        return $this;
    }

    public function getPrerequisite(): ?string
    {
        return $this->prerequisite;
    }

    public function setPrerequisite(?string $prerequisite): self
    {
        $this->prerequisite = $prerequisite;

        return $this;
    }

    public function getPurpose(): ?string
    {
        return $this->purpose;
    }

    public function setPurpose(string $purpose): self
    {
        $this->purpose = $purpose;

        return $this;
    }

    public function getFinality(): ?string
    {
        return $this->finality;
    }

    public function setFinality(?string $finality): self
    {
        $this->finality = $finality;

        return $this;
    }

    public function getContents(): ?string
    {
        return $this->contents;
    }

    public function setContents(string $contents): self
    {
        $this->contents = $contents;

        return $this;
    }

    public function getPrices(): ?int
    {
        return $this->prices;
    }

    public function getFormatedPrice(string $accuracy = "Ar")
    {
        $accuracy = strtolower($accuracy);

        $price = number_format($this->prices, 0, ',', ' ');

        return $formatedPrice = ($accuracy == "ar") ?  $price . ' Ar' : $price . ' €' ;
    }

    public function setPrices(?int $prices): self
    {
        $this->prices = $prices;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function isPriority(): ?bool
    {
        return $this->priority;
    }

    public function setPriority(bool $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getVignetteUrl(): ?string
    {
        return $this->vignette_url;
    }

    public function setVignetteUrl(string $vignette_url): self
    {
        $this->vignette_url = $vignette_url;

        return $this;
    }
}
