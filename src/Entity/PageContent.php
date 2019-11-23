<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageContentRepository")
 */
class PageContent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Image", mappedBy="pageContent")
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PageContainer", inversedBy="pageContents")
     */
    private $pageContainer;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $orderBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Link", inversedBy="pageContents")
     */
    private $link;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->addArticle($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            $image->removeArticle($this);
        }

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

    public function getOrderBy(): ?int
    {
        return $this->orderBy;
    }

    public function setOrderBy(?int $orderBy): self
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    public function getLink(): ?Link
    {
        return $this->link;
    }

    public function setLink(?Link $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function isImageButton()
    {
        $doc = new \DOMDocument();
        $doc->loadHTML($this->content);
        $text = $doc->getElementsByTagName ("p");
        $img = $doc->getElementsByTagName ("img");
        return ($text->length === 0 && $img->length === 1 && $this->link !== null) ? true : false; 
    }
}