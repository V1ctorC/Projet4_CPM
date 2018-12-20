<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as OwnAssert;

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
     * @ORM\Column(type="datetime", length=255)
     * @Assert\DateTime
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual("today", message="La date doit être au moins celle d'aujourd'hui")
     * @OwnAssert\CheckBookingDate()
     */
    private $bookingday;

    /**
     * @ORM\Column(type="string", length=1)
     * @Assert\NotNull(message="Vous devez selectionner un type de ticket")
     * @OwnAssert\CheckBookingType
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     */
    private $paid;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *     min = 1,
     *     max = 10,
     *     minMessage="Vous devez réserver au moins 1 billet",
     *     maxMessage="Vous ne pouvez réserver plus de 10 billets"
     * )
     */
    private $quantity;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Information", mappedBy="idbooking")
     */
    private $information;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mail;

    public function __construct()
    {
        $this->setPaid(0);
        $this->information = new ArrayCollection();
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

    /**
     * @return Collection|Information[]
     */
    public function getInformation(): Collection
    {
        return $this->information;
    }

    public function addInformation(Information $information): self
    {
        if (!$this->information->contains($information)) {
            $this->information[] = $information;
            $information->setIdbooking($this);
        }

        return $this;
    }

    public function removeInformation(Information $information): self
    {
        if ($this->information->contains($information)) {
            $this->information->removeElement($information);
            // set the owning side to null (unless already changed)
            if ($information->getIdbooking() === $this) {
                $information->setIdbooking(null);
            }
        }

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getBookingday(): ?\DateTimeInterface
    {
        return $this->bookingday;
    }

    public function setBookingday(\DateTimeInterface $bookingday): self
    {
        $this->bookingday = $bookingday;

        return $this;
    }
}
