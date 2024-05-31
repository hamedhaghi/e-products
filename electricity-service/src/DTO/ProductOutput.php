<?php

declare(strict_types=1);

namespace App\DTO;

class ProductOutput
{
    public function __construct(
        public string $name,
        public float $annualCosts,
    ) {
    }
}
