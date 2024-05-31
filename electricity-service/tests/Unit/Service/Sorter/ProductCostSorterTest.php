<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Sorter;

use App\DTO\ProductOutput;
use App\Service\Sorter\ProductCostSorter;
use PHPUnit\Framework\TestCase;

class ProductCostSorterTest extends TestCase
{
    public function testSort(): void
    {
        $products = [
            new ProductOutput('test', 2000),
            new ProductOutput('test', 1000),
            new ProductOutput('test', 3000),
            new ProductOutput('test', 4000),
        ];

        $sorted = (new ProductCostSorter())->sort($products);
        $this->assertIsArray($sorted);
        $this->assertNotEquals($products, $sorted);
        $this->assertNotSame($products, $sorted);
        $this->assertSameSize($products, $sorted);
    }
}
