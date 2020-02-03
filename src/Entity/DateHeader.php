<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DateHeaderRepository")
 */
class DateHeader
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="dateHeaders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Unit", inversedBy="dateHeaders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $unit;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maxQuantity = 8;

    private $availabilityQuantity;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DateLine", mappedBy="dateHeader")
     */
    private $dateLines;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="dateHeader")
     */
    private $bookings;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $details;

    public function __construct()
    {
        $this->dateLines = new ArrayCollection();
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

    public function getMaxQuantity(): ?int
    {
        return $this->maxQuantity;
    }

    public function setMaxQuantity(?int $maxQuantity): self
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
        return (new DateTime() > $this->dateLines) ? 1 : 0;
    }

    /**
     * @return Collection|DateLine[]
     */
    public function getDateLines(): Collection
    {
        return $this->dateLines;
    }

    public function addDate(DateLine $dateLine): self
    {
        if (!$this->dateLines->contains($dateLine)) {
            $this->dateLines[] = $dateLine;
            $dateLine->setDateHeader($this);
        }

        return $this;
    }

    public function removeDate(DateLine $dateLine): self
    {
        if ($this->dateLines->contains($dateLine)) {
            $this->dateLines->removeElement($dateLine);
            // set the owning side to null (unless already changed)
            if ($dateLine->getDateHeader() === $this) {
                $dateLine->setDateHeader(null);
            }
        }

        return $this;
    }

    public function getEditableDateLines(): ?string
    {
        if (!empty($this->dateLines->toArray())) {
            if (count($this->dateLines->toArray()) > 1) {
                $dateLinesEditable = array_map(function($dateLine){
                    return $dateLine->getDate()->format('d M à h:m');
                }, $this->dateLines->toArray());
                return $this->unit->getLabel().' les '.implode(' - ', $dateLinesEditable);
            } else {
                $dateLine = $this->dateLines[0];
                return $dateLine->getDate()->format('l j F Y \d\e H\hi')
                .' à '.$dateLine->getDateEnd()->format('H\hi');
            }
        } else {
            return null;
        }
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
            $booking->setDateHeader($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getDateHeader() === $this) {
                $booking->setDateHeader(null);
            }
        }

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

        return $this;
    }
}
