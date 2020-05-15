<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FamilyRepository")
 */
class Family
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="family")
     */
    private $products;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Unit", mappedBy="families")
     * @ORM\OrderBy({"duration" = "ASC", "id" = "ASC"})
     */
    private $units;

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    private $hasUniquesPrices;

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    private $hasSeasonalProducts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Family")
     */
    private $parent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image")
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $shortName;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PageContent", mappedBy="families")
     */
    private $pageContents;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->units = new ArrayCollection();
        $this->pageContents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): ArrayCollection
    {
        $products = [];
        foreach ($this->products as $product) {
            if(false === $product->getIsGeneric()) {
                $products[] = $product;
            }
        }
        return new ArrayCollection($products);
    }

    public function getGenericProduct(): ?Product
    {
        foreach ($this->products as $product) {
            if(true === $product->getIsGeneric()) {
                return $product;
            }
        }
        return null;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setFamily($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getFamily() === $this) {
                $product->setFamily(null);
            }
        }

        return $this;
    }

        /**
     * @return ArrayCollection
     */
    public function getProductsOrderByMonth(): ArrayCollection
    {
        $productsIterator = self::getProducts()->getIterator();

        $today = new DateTime();
        $month = $today->format('m');

        $productsIterator->uasort(function ($a, $b) use ($month) {
            $orderA = ($a->getOrderBy() < $month  || 0 == count($a->getActiveDateHeaders())) ? $a->getOrderBy() + 12 : $a->getOrderBy();
            $orderB = ($b->getOrderBy() < $month  || 0 == count($b->getActiveDateHeaders())) ? $b->getOrderBy() + 12 : $b->getOrderBy();
            if($orderA == $orderB) {
                return 0;
            }
            return ($orderA < $orderB) ? -1 : 1;
        });

        return new ArrayCollection(iterator_to_array($productsIterator));
    }

        /**
     * @return ArrayCollection
     */
    public function getFirstOnesProducts($count = 1): ArrayCollection
    {
        $productsIterator = $this->products->getIterator();
        $today = new DateTime();
        $month = $today->format('m');
        $products = [];
        foreach ($productsIterator as $product) {
            $orderBy = ($product->getOrderBy() < $month  || 0 == count($product->getActiveDateHeaders())) ? $product->getOrderBy() + 12 : $product->getOrderBy();
            if (false === $product->getIsGeneric()) {
                $products[$orderBy] = $product;
            }
        }
        ksort($products);

        return new ArrayCollection(array_slice($products,0,$count));
    }

    /**
     * @return Collection|Unit[]
     */
    public function getUnits(): Collection
    {
        return $this->units;
    }

    public function addUnit(Unit $unit): self
    {
        if (!$this->units->contains($unit)) {
            $this->units[] = $unit;
            $unit->addFamily($this);
        }

        return $this;
    }

    public function removeUnit(Unit $unit): self
    {
        if ($this->units->contains($unit)) {
            $this->units->removeElement($unit);
            $unit->removeFamily($this);
        }

        return $this;
    }

    public function getHasUniquesPrices(): ?bool
    {
        return $this->hasUniquesPrices;
    }

    public function setHasUniquesPrices(bool $hasUniquesPrices): self
    {
        $this->hasUniquesPrices = $hasUniquesPrices;

        return $this;
    }

    public function getHasSeasonalProducts(): ?bool
    {
        return $this->hasSeasonalProducts;
    }

    public function setHasSeasonalProducts(bool $hasSeasonalProducts): self
    {
        $this->hasSeasonalProducts = $hasSeasonalProducts;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(?string $shortName): self
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * @return Collection|PageContent[]
     */
    public function getPageContents(): Collection
    {
        return $this->pageContents;
    }

    public function addPageContent(PageContent $pageContent): self
    {
        if (!$this->pageContents->contains($pageContent)) {
            $this->pageContents[] = $pageContent;
            $pageContent->addFamily($this);
        }

        return $this;
    }

    public function removePageContent(PageContent $pageContent): self
    {
        if ($this->pageContents->contains($pageContent)) {
            $this->pageContents->removeElement($pageContent);
            $pageContent->removeFamily($this);
        }

        return $this;
    }
}
