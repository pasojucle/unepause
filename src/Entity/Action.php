<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActionRepository")
 */
class Action
{
    const FRONT_OFFICE = 1;
    const BACK_OFFICE = 2;
    
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
     * @ORM\OneToMany(targetEntity="App\Entity\Page", mappedBy="action")
     * @ORM\OrderBy({"orderBy" = "ASC"})
     */
    private $pages;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Container", inversedBy="actions")
     */
    private $container;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $icon;

    /**
     * @ORM\Column(type="boolean", options={"default" : 0})
     */
    private $isAnchor;

    /**
     * @ORM\Column(type="integer")
     */
    private $office;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $orderBy;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
        $this->container = new ArrayCollection();
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

    /**
     * @return Collection|Page[]
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Page $page): self
    {
        if (!$this->pages->contains($page)) {
            $this->pages[] = $page;
            $page->setAction($this);
        }

        return $this;
    }

    public function removePage(Page $page): self
    {
        if ($this->pages->contains($page)) {
            $this->pages->removeElement($page);
            // set the owning side to null (unless already changed)
            if ($page->getAction() === $this) {
                $page->setAction(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Container[]
     */
    public function getContainer(): Collection
    {
        return $this->container;
    }

    public function addContainer(Container $container): self
    {
        if (!$this->container->contains($container)) {
            $this->container[] = $container;
        }

        return $this;
    }

    public function removeContainer(Container $container): self
    {
        if ($this->container->contains($container)) {
            $this->container->removeElement($container);
        }

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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIsAnchor(): ?bool
    {
        return $this->isAnchor;
    }

    public function setIsAnchor(bool $isAnchor): self
    {
        $this->isAnchor = $isAnchor;

        return $this;
    }

    public function getOffice(): ?int
    {
        return $this->office;
    }

    public function setOffice(int $office): self
    {
        $this->office = $office;

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
}
