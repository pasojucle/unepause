<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    const HARDWARE = 1;
    const SCHEDULE_SERVICE = 2;
    const APPOINTMENT_SERVICE = 3;
    const BESPOKE_SERVICE = 4;


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Price", mappedBy="product")
     */
    private $prices;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Family", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $family;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $orderBy;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Image", inversedBy="products")
     */
    private $images;

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    private $isGeneric;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="integer", options={"default": 1})
     */
    private $type = 1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $summary;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DateHeader", mappedBy="product")
     */
    private $dateHeaders;

    public function __construct()
    {
        $this->prices = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->dateHeaders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $price->setProduct($this);
        }

        return $this;
    }

    public function removePrice(Price $price): self
    {
        if ($this->prices->contains($price)) {
            $this->prices->removeElement($price);
            // set the owning side to null (unless already changed)
            if ($price->getProduct() === $this) {
                $price->setProduct(null);
            }
        }

        return $this;
    }

    public function getFamily(): ?Family
    {
        return $this->family;
    }

    public function setFamily(?Family $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getOrderBy(): ?int
    {
        return $this->orderBy;
    }

    public function setOrderBy(?int $orderBy): self
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
        }

        return $this;
    }

    public function getIsGeneric(): ?bool
    {
        return $this->isGeneric;
    }

    public function setIsGeneric(bool $isGeneric): self
    {
        $this->isGeneric = $isGeneric;

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

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $typec): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

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
            $dateHeader->setProduct($this);
        }

        return $this;
    }

    public function removeDateHeader(DateHeader $dateHeader): self
    {
        if ($this->dateHeaders->contains($dateHeader)) {
            $this->dateHeaders->removeElement($dateHeader);
            // set the owning side to null (unless already changed)
            if ($dateHeader->getProduct() === $this) {
                $dateHeader->setProduct(null);
            }
        }

        return $this;
    }

     /**
     * @return Collection|DateHeader[]
     */
    public function getActiveDateHeaders(): Collection
    {
        $dateHeaders = [];
        $dateHeadersIterator = self::getDateHeaders()->getIterator();
        $today = new DateTime();
        foreach ($dateHeadersIterator as $dateHeader) {
            $isActive = true;
            foreach ($dateHeader->getDateLines() as $dateLine) {
                if($today >= $dateLine->getDate()) {
                    $isActive = false;
                }
            }
            if (true === $isActive) {
                $dateHeaders[] = $dateHeader;
            }
            
        }
        return new ArrayCollection($dateHeaders);
    }

}
