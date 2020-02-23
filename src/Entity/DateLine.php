<?php

namespace App\Entity;

use DateTime;
use App\DateTime\DateTimeFrench;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DateLineRepository")
 */
class DateLine
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DateHeader", inversedBy="dateLines")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dateHeader;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->date = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?DateTimeFrench
    {
        return (null !== $this->date) ? new DateTimeFrench($this->date->format('Y-m-d H:i:s')) : null;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        $unit = $this->getDateHeader()->getUnit();
        $interval = new \DateInterval('PT'.$unit->getDuration().'M');
        $dateEnd = clone $this->date; 
        return $dateEnd->add($interval);
    }

    public function getDateHeader(): ?DateHeader
    {
        return $this->dateHeader;
    }

    public function setDateHeader(?DateHeader $dateHeader): self
    {
        $this->dateHeader = $dateHeader;

        return $this;
    }
}
