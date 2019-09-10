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
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", inversedBy="images")
     */
    private $article;

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
        $this->article = new ArrayCollection();
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
     * @return Collection|Article[]
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->article->contains($article)) {
            $this->article->removeElement($article);
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
