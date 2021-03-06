<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as OwnAssert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InformationRepository")
 */
class Information
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ doit être rempli")
     * @Assert\Length(min=2, minMessage="Votre prénom doit comporter au moins 2 caractères")
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre prénom ne doit pas comporter de chiffre"
     * )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champs doit être rempli")
     * @Assert\Length(min=2, minMessage="Votre nom doit comporter au moins 2 caractères")
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre nom ne doit pas comporter de chiffre"
     * )
     */
    private $lastname;

    /**
     * @ORM\Column(type="datetime", length=255)
     * @Assert\DateTime(message="Le champ est invalide")
     * @Assert\NotBlank(message="Le champ doit être rempli")
     * @Assert\LessThan(value="today", message="Vous devez être né avant aujourd'hui")
     * @OwnAssert\CheckBirthdate()
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Vous devez sélectionner un pays")
     */
    private $country;

    /**
     * @ORM\Column(type="boolean")
     */
    private $reducedprice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Booking", inversedBy="information")
     */
    private $idbooking;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getReducedprice(): ?bool
    {
        return $this->reducedprice;
    }

    public function setReducedprice(bool $reducedprice): self
    {
        $this->reducedprice = $reducedprice;

        return $this;
    }

    public function getIdbooking(): ?Booking
    {
        return $this->idbooking;
    }

    public function setIdbooking(?Booking $idbooking): self
    {
        $this->idbooking = $idbooking;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate($birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }
}
