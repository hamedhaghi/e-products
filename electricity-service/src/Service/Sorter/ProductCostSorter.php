<?php

declare(strict_types=1);

namespace App\Service\Sorter;

use App\DTO\ProductOutput;

class ProductCostSorter implements ProductSortInterface
{
    public function sort(array $products): array
    {
        usort($products, fn (ProductOutput $a, ProductOutput $b) => $a->annualCosts <=> $b->annualCosts);

        return $products;
    }
}
