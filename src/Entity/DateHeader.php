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
    const DEFAULT_MAX_QUANTITY = 8;
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
    private $maxQuantity = self::DEFAULT_MAX_QUANTITY;

    private $availabilityQuantity;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DateLine", mappedBy="dateHeader", cascade={"persist"})
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

    /**
     * @ORM\Column(type="boolean")
     */
    private $isGeneric = 0;

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

    public function addDateLine(DateLine $dateLine): self
    {
        if (!$this->dateLines->contains($dateLine)) {
            $this->dateLines[] = $dateLine;
            $dateLine->setDateHeader($this);
        }

        return $this;
    }

    public function removeDateLine(DateLine $dateLine): self
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

    public function getLongDateLines(): ?array
    {
        if (!empty($this->dateLines->toArray())) {
            $longDateLines = array_map(function($dateLine){
                return $dateLine->getDate()->format('l j F  \d\e G\hi')
                .' à '.$dateLine->getDateEnd()->format('G\hi');
            }, $this->dateLines->toArray());
            return [
                'unit' =>$this->unit->getLabel(),
                'dateLines' => $longDateLines
            ];
        } else {
            return [
                'unit' =>$this->unit->getLabel(),
                'dateLines' => []
            ];
        }
        return null;
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

    public function getIsGeneric(): ?bool
    {
        return $this->isGeneric;
    }

    public function setIsGeneric(bool $isGeneric): self
    {
        $this->isGeneric = $isGeneric;

        return $this;
    }
}
