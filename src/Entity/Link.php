<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LinkRepository")
 */
class Link
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Page", inversedBy="links")
     */
    private $page;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PageContainer", inversedBy="links")
     */
    private $pageContainer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PageContent", mappedBy="link")
     */
    private $pageContents;

    public function __construct()
    {
        $this->pageContents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPageContainer(): ?PageContainer
    {
        return $this->pageContainer;
    }

    public function setPageContainer(?PageContainer $pageContainer): self
    {
        $this->pageContainer = $pageContainer;

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
            $pageContent->setLink($this);
        }

        return $this;
    }

    public function removePageContent(PageContent $pageContent): self
    {
        if ($this->pageContents->contains($pageContent)) {
            $this->pageContents->removeElement($pageContent);
            // set the owning side to null (unless already changed)
            if ($pageContent->getLink() === $this) {
                $pageContent->setLink(null);
            }
        }

        return $this;
    }
}