<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
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
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PageContent", inversedBy="images")
     */
    private $pageContent;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $filenameMd;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $filenameXs;

    public function __construct()
    {
        $this->pageContent = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
    public function getPageContent(): Collection
    {
        return $this->pageContent;
    }

    public function addPageContent(PageContent $pageContent): self
    {
        if (!$this->pageContent->contains($pageContent)) {
            $this->pageContent[] = $pageContent;
        }

        return $this;
    }

    public function removePageContent(PageContent $pageContent): self
    {
        if ($this->pageContent->contains($pageContent)) {
            $this->pageContent->removeElement($pageContent);
        }

        return $this;
    }

    public function getFilenameMd(): ?string
    {
        return $this->filenameMd;
    }

    public function setFilenameMd(string $filenameMd): self
    {
        $this->filenameMd = $filenameMd;

        return $this;
    }

    public function getFilenameXs(): ?string
    {
        return $this->filenameXs;
    }

    public function setFilenameXs(string $filenameXs): self
    {
        $this->filenameXs = $filenameXs;

        return $this;
    }
}
