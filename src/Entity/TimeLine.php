<?php

namespace App\Entity;

use App\DateTime\DateTimeFrench;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TimeLineRepository")
 */
class TimeLine
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="timeLines")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Unit", inversedBy="timeLines")
     */
    private $unit;

    /**
     * @ORM\Column(type="datetime")
     */
    private $day;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getUnit(): ?Unit
    {
        return $this->unit;
    }

    public function setUnit(?Unit $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getDay(): ?DateTimeFrench
    {
        return new DateTimeFrench($this->day->format('Y-m-d H:i:s'));
    }

    public function setDay(\DateTimeInterface $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getDayEnd(): ?\DateTimeInterface
    {
        $interval = new \DateInterval('PT'.$this->unit->getDuration().'M');
        return $this->day->add($interval);
    }
}
