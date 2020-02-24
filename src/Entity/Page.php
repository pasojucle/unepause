<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 */
class Page
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
     * @ORM\Column(type="string", length=50)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Template")
     * @ORM\JoinColumn(nullable=false)
     */
    private $template;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PageContainer", mappedBy="page")
     * @ORM\OrderBy({"orderBy" = "ASC"})
     */
    private $pageContainers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Action", inversedBy="pages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $action;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Link", mappedBy="page")
     */
    private $links;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $orderBy;

    /**
     * @ORM\Column(type="boolean", options={"default" : 1})
     */
    private $isActive;

    public function __construct()
    {
        $this->pageContainers = new ArrayCollection();
        $this->links = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTemplate(): ?Template
    {
        return $this->template;
    }

    public function setTemplate(?Template $template): self
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return Collection|PageContainer[]
     */
    public function getPageContainers(): Collection
    {
        return $this->pageContainers;
    }

    public function addPageContainer(PageContainer $pageContainer): self
    {
        if (!$this->pageContainers->contains($pageContainer)) {
            $this->pageContainers[] = $pageContainer;
            $pageContainer->setPage($this);
        }

        return $this;
    }

    public function removePageContainer(PageContainer $pageContainer): self
    {
        if ($this->pageContainers->contains($pageContainer)) {
            $this->pageContainers->removeElement($pageContainer);
            // set the owning side to null (unless already changed)
            if ($pageContainer->getPage() === $this) {
                $pageContainer->setPage(null);
            }
        }

        return $this;
    }

    public function getAction(): ?Action
    {
        return $this->action;
    }

    public function setAction(?Action $action): self
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return Collection|Link[]
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(Link $link): self
    {
        if (!$this->links->contains($link)) {
            $this->links[] = $link;
            $link->setPage($this);
        }

        return $this;
    }

    public function removeLink(Link $link): self
    {
        if ($this->links->contains($link)) {
            $this->links->removeElement($link);
            // set the owning side to null (unless already changed)
            if ($link->getPage() === $this) {
                $link->setPage(null);
            }
        }

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

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
