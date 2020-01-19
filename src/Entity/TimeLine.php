<?php

namespace App\Entity;

use DateTime;
use App\DateTime\DateTimeFrench;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="timeLine")
     */
    private $bookings;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxQuantity = 1;

    private $availabilityQuantity;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

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
        return (null !== $this->day) ? new DateTimeFrench($this->day->format('Y-m-d H:i:s')) : null;
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

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setTimeLine($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getTimeLine() === $this) {
                $booking->setTimeLine(null);
            }
        }

        return $this;
    }

    public function getMaxQuantity(): ?int
    {
        return $this->maxQuantity;
    }

    public function setMaxQuantity(int $maxQuantity): self
    {
        $this->maxQuantity = $maxQuantity;

        return $this;
    }

    public function getAvailabilityQuantity(): ?int
    {
        return $this->availabilityQuantity;
    }

    public function setAvailabilityQuantity(int $availabilityQuantity): self
    {
        $this->availabilityQuantity = $availabilityQuantity;

        return $this;
    }

    public function isPastDate(): bool
    {
        return (new DateTime() > $this->day) ? 1 : 0;
    }
}
