<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClassDomElementRepository")
 */
class ClassDomElement
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
     * @ORM\OneToMany(targetEntity="App\Entity\PageContainer", mappedBy="class")
     */
    private $pageContainers;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PageContent", mappedBy="class")
     */
    private $pageContents;

    public function __construct()
    {
        $this->pageContainers = new ArrayCollection();
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
            $pageContainer->setClass($this);
        }

        return $this;
    }

    public function removePageContainer(PageContainer $pageContainer): self
    {
        if ($this->pageContainers->contains($pageContainer)) {
            $this->pageContainers->removeElement($pageContainer);
            // set the owning side to null (unless already changed)
            if ($pageContainer->getClass() === $this) {
                $pageContainer->setClass(null);
            }
        }

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
            $pageContent->setClass($this);
        }

        return $this;
    }

    public function removePageContent(PageContent $pageContent): self
    {
        if ($this->pageContents->contains($pageContent)) {
            $this->pageContents->removeElement($pageContent);
            // set the owning side to null (unless already changed)
            if ($pageContent->getClass() === $this) {
                $pageContent->setClass(null);
            }
        }

        return $this;
    }
}
