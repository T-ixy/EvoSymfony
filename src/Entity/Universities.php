<?php

namespace App\Entity;

use App\Repository\UniversitiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UniversitiesRepository::class)]
class Universities
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $University = null;

    #[ORM\Column(length: 255)]
    private ?string $logo_url = null;

    #[ORM\OneToMany(mappedBy: 'university', targetEntity: Formations::class, orphanRemoval: true)]
    private Collection $formations;

    #[ORM\Column(length: 255)]
    private ?string $login_url = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $site_url = null;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUniversity(): ?string
    {
        return $this->University;
    }

    public function setUniversity(string $University): self
    {
        $this->University = $University;

        return $this;
    }

    public function getLogoUrl(): ?string
    {
        return $this->logo_url;
    }

    public function setLogoUrl(string $logo_url): self
    {
        $this->logo_url = $logo_url;

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
            $formation->setUniversity($this);
        }

        return $this;
    }

    public function removeFormation(Formations $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getUniversity() === $this) {
                $formation->setUniversity(null);
            }
        }

        return $this;
    }

    public function getLoginUrl(): ?string
    {
        return $this->login_url;
    }

    public function setLoginUrl(string $login_url): self
    {
        $this->login_url = $login_url;

        return $this;
    }

    public function getSiteUrl(): ?string
    {
        return $this->site_url;
    }

    public function setSiteUrl(?string $site_url): self
    {
        $this->site_url = $site_url;

        return $this;
    }
}
