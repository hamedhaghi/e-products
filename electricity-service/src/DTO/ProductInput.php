<?php

declare(strict_types=1);

namespace App\DTO;

class ProductInput
{
    public int $id;
    public string $name;
    public int $type;
    public float $baseCost;
    public float $additionalKwhCost;
    public ?int $includedKwh = null;

    public function isBasic(): bool
    {
        return 1 === $this->type;
    }

    public function isPackaged(): bool
    {
        return 2 === $this->type;
    }

    public function getAnnualCost(int $consumption): float
    {
        if ($this->isPackaged()) {
            if ($consumption > $this->includedKwh) {
                $extraConsumption = $consumption - $this->includedKwh;

                return $this->baseCost + ($extraConsumption * ($this->additionalKwhCost / 100));
            }

            return $this->baseCost;
        }

        return ($this->baseCost * 12) + ($consumption * ($this->additionalKwhCost / 100));
    }
}
