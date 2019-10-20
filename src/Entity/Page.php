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
     */
    private $pageContainers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Action", inversedBy="pages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $action;

    public function __construct()
    {
        $this->pageContainers = new ArrayCollection();
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
}
