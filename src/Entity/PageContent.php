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
     * @ORM\ManyToOne(targetEntity="App\Entity\Page")
     * @ORM\JoinColumn(nullable=false)
     */
    private $page;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Image", mappedBy="pageContent")
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Family", mappedBy="pageContent")
     */
    private $families;

//    /**
//     * @ORM\ManyToOne(targetEntity="App\Entity\PageContainer")
//     * @ORM\JoinColumn(nullable=true)
//     */
//    private $pageContainer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PageContentType")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PageContainer", inversedBy="pageContents")
     */
    private $pageContainer;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->families = new ArrayCollection();
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
            $family->setArticle($this);
        }

        return $this;
    }

    public function removeFamily(Family $family): self
    {
        if ($this->families->contains($family)) {
            $this->families->removeElement($family);
            // set the owning side to null (unless already changed)
            if ($family->getArticle() === $this) {
                $family->setArticle(null);
            }
        }

        return $this;
    }

    /*public function getPageContainer(): ?PageContainer
    {
        return $this->pageContainer;
    }

    public function setPageContainer(?PageContainer $pageContainer): self
    {
        $this->pageContainer = $pageContainer;

        return $this;
    }*/

    public function getType(): ?PageContentType
    {
        return $this->type;
    }

    public function setType(?PageContentType $type): self
    {
        $this->type = $type;

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
}
