<?php

declare(strict_types=1);

namespace App\Service\Sorter;

use App\DTO\ProductOutput;

interface ProductSortInterface
{
    /**
     * @param ProductOutput[] $products
     *
     * @return ProductOutput[]
     */
    public function sort(array $products): array;
}
