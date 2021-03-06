<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageContainerRepository")
 */
class PageContainer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Container")
     * @ORM\JoinColumn(nullable=false)
     */
    private $container;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Page", inversedBy="pageContainers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $page;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PageContent", mappedBy="pageContainer")
     * @ORM\OrderBy({"orderBy" = "ASC"})
     */
    private $pageContents;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ClassDomElement", inversedBy="pageContainers")
     */
    private $class;

    /**
     * @ORM\Column(type="integer")
     */
    private $orderBy;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $footer;

    public function __construct()
    {
        $this->pageContents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContainer(): ?Container
    {
        return $this->container;
    }

    public function setContainer(?Container $container): self
    {
        $this->container = $container;

        return $this;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): self
    {
        $this->page = $page;

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
            $pageContent->setPageContainer($this);
        }

        return $this;
    }

    public function removePageContent(PageContent $pageContent): self
    {
        if ($this->pageContents->contains($pageContent)) {
            $this->pageContents->removeElement($pageContent);
            // set the owning side to null (unless already changed)
            if ($pageContent->getPageContainer() === $this) {
                $pageContent->setPageContainer(null);
            }
        }

        return $this;
    }

    public function getClass(): ?ClassDomElement
    {
        return $this->class;
    }

    public function setClass(?ClassDomElement $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getOrderBy(): ?int
    {
        return $this->orderBy;
    }

    public function setOrderBy(int $orderBy): self
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFooter(): ?string
    {
        return $this->footer;
    }

    public function setFooter(?string $footer): self
    {
        $this->footer = $footer;

        return $this;
    }

    public function getItems()
    {
        $items = [];
        $families = self::getFamilies();
        foreach ($families as $family) {
            if (self::getContainer()->getId() == Container::INTRODUCTION_LIST) {
                if (1 == $family->getHasSeasonalProducts()) {
                    $items = Array_merge($family->getFirstOnesProducts()->toArray(), $items);
                } else {
                    $products = $family->getProducts()->toArray();
                    $items = Array_merge(array_slice($products,0,1), $items);
                }
            } else {
                $items = (true === $family->getHasSeasonalProducts())
                ? Array_merge($family->getProductsOrderByMonth()->toArray(), $items) 
                : Array_merge($family->getProducts()->toArray(), $items);
            }
        }
        $pageContentsIterator = self::getPageContents()->getIterator();
        $items = Array_merge($items, iterator_to_array($pageContentsIterator));

        return new ArrayCollection($items);

    }
}
