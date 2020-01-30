<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UnitRepository")
 */
class Unit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $label;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Family", inversedBy="units")
     */
    private $families;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Price", mappedBy="unit")
     */
    private $prices;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duration;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DateHeader", mappedBy="unit")
     */
    private $dateHeaders;

    public function __construct()
    {
        $this->families = new ArrayCollection();
        $this->prices = new ArrayCollection();
        $this->dateHeaders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection|Family[]
     */
    public function getFamilies(): Collection
    {
        return $this->families;
    }

    public function addFamily(Family $family): self
    {
        if (!$this->families->contains($family)) {
            $this->families[] = $family;
        }

        return $this;
    }

    public function removeFamily(Family $family): self
    {
        if ($this->families->contains($family)) {
            $this->families->removeElement($family);
        }

        return $this;
    }

    /**
     * @return Collection|Price[]
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function addPrice(Price $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices[] = $price;
            $price->setPrice($this);
        }

        return $this;
    }

    public function removePrice(Price $price): self
    {
        if ($this->prices->contains($price)) {
            $this->price->removeElement($price);
            // set the owning side to null (unless already changed)
            if ($price->getPrice() === $this) {
                $price->setPrice(null);
            }
        }

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection|DateHeader[]
     */
    public function getDateHeaders(): Collection
    {
        return $this->dateHeaders;
    }

    public function addDateHeader(DateHeader $dateHeader): self
    {
        if (!$this->dateHeaders->contains($dateHeader)) {
            $this->dateHeaders[] = $dateHeader;
            $dateHeader->setUnit($this);
        }

        return $this;
    }

    public function removeDateHeader(DateHeader $dateHeader): self
    {
        if ($this->dateHeaders->contains($dateHeader)) {
            $this->dateHeaders->removeElement($dateHeader);
            // set the owning side to null (unless already changed)
            if ($dateHeader->getUnit() === $this) {
                $dateHeader->setUnit(null);
            }
        }

        return $this;
    }
}
