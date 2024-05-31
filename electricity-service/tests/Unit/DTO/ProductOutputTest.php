<?php

declare(strict_types=1);

namespace App\Tests\Unit\DTO;

use App\DTO\ProductOutput;
use PHPUnit\Framework\TestCase;

class ProductOutputTest extends TestCase
{
    public function testProductOutputProperties(): void
    {
        $productOutput = new ProductOutput(
            'test',
            2000,
        );

        $this->assertInstanceOf(ProductOutput::class, $productOutput);
        $this->assertEquals('test', $productOutput->name);
        $this->assertEquals(2000, $productOutput->annualCosts);
    }
}
