<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserDetailRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserDetailRepository::class)]
#[ApiResource]
class UserDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    private ?string $zipcode = null;

    #[ORM\Column(length: 255)]
    private ?string $shortZipcode = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $specialty = null;

    #[ORM\Column(type: Types::JSON)]
    private array $stack = [];

    #[ORM\Column(length: 255)]
    private ?string $geometryType = null;

    #[ORM\Column(type: Types::JSON)]
    private array $geometryCoordinates = [];

    #[ORM\OneToOne(inversedBy: 'userDetail', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): static
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getShortZipcode(): ?string
    {
        return $this->shortZipcode;
    }

    public function setShortZipcode(string $shortZipcode): static
    {
        $this->shortZipcode = $shortZipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getSpecialty(): ?string
    {
        return $this->specialty;
    }

    public function setSpecialty(string $specialty): static
    {
        $this->specialty = $specialty;

        return $this;
    }

    public function getStack(): array
    {
        return $this->stack;
    }

    public function setStack(array $stack): static
    {
        $this->stack = $stack;

        return $this;
    }

    public function getGeometryType(): ?string
    {
        return $this->geometryType;
    }

    public function setGeometryType(string $geometryType): static
    {
        $this->geometryType = $geometryType;

        return $this;
    }

    public function getGeometryCoordinates(): array
    {
        return $this->geometryCoordinates;
    }

    public function setGeometryCoordinates(array $geometryCoordinates): static
    {
        $this->geometryCoordinates = $geometryCoordinates;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }
}