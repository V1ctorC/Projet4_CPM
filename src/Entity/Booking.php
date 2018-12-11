<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bookingnumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bookingday;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     */
    private $paid;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function __construct()
    {
        $this->setPaid(0);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookingnumber(): ?string
    {
        return $this->bookingnumber;
    }

    public function setBookingnumber(string $bookingnumber): self
    {
        $this->bookingnumber = $bookingnumber;

        return $this;
    }

    public function getBookingday(): ?string
    {
        return $this->bookingday;
    }

    public function setBookingday(string $bookingday): self
    {
        $this->bookingday = $bookingday;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPaid(): ?bool
    {
        return $this->paid;
    }

    public function setPaid(bool $paid): self
    {
        $this->paid = $paid;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
