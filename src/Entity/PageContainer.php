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
     * @ORM\ManyToOne(targetEntity="App\Entity\ClassContainer", inversedBy="pageContainers")
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

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Family", mappedBy="pageContainers")
     */
    private $families;

    public function __construct()
    {
        $this->pageContents = new ArrayCollection();
        $this->families = new ArrayCollection();
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

    public function getClass(): ?ClassContainer
    {
        return $this->class;
    }

    public function setClass(?ClassContainer $class): self
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
            $family->addPageContainer($this);
        }

        return $this;
    }

    public function removeFamily(Family $family): self
    {
        if ($this->families->contains($family)) {
            $this->families->removeElement($family);
            $family->removePageContainer($this);
        }

        return $this;
    }
}
