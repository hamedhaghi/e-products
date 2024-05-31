<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource]
#[GetCollection(paginationEnabled: false)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $type = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?float $baseCost = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?float $additionalKwhCost = null;

    #[ORM\Column(nullable: true)]
    private ?int $includedKwh = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getBaseCost(): ?float
    {
        return $this->baseCost;
    }

    public function setBaseCost(float $baseCost): static
    {
        $this->baseCost = $baseCost;

        return $this;
    }

    public function getAdditionalKwhCost(): ?float
    {
        return $this->additionalKwhCost;
    }

    public function setAdditionalKwhCost(float $additionalKwhCost): static
    {
        $this->additionalKwhCost = $additionalKwhCost;

        return $this;
    }

    public function getIncludedKwh(): ?int
    {
        return $this->includedKwh;
    }

    public function setIncludedKwh(?int $includedKwh): static
    {
        $this->includedKwh = $includedKwh;

        return $this;
    }
}
