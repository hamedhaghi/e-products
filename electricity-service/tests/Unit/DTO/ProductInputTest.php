<?php

declare(strict_types=1);

namespace App\Tests\Unit\DTO;

use App\DTO\ProductInput;
use PHPUnit\Framework\TestCase;

class ProductInputTest extends TestCase
{
    protected ProductInput $productInput;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productInput = new ProductInput();
        $this->productInput->id = 1;
        $this->productInput->name = 'test';
        $this->productInput->additionalKwhCost = 22.00;
    }

    public function testIsBasicType(): void
    {
        $this->productInput->type = 1;
        $this->assertTrue($this->productInput->isBasic());
    }

    public function testIsPackagedType(): void
    {
        $this->productInput->type = 2;
        $this->assertTrue($this->productInput->isPackaged());
    }

    public function testBasicTypeAnnualCostCalculation(): void
    {
        $this->productInput->baseCost = 5.00;
        $this->productInput->type = 1;
        $this->assertEquals(830, $this->productInput->getAnnualCost(3500));
        $this->assertEquals(1050, $this->productInput->getAnnualCost(4500));
    }

    public function testPackagedTypeAnnualCostCalculation(): void
    {
        $this->productInput->baseCost = 800.00;
        $this->productInput->additionalKwhCost = 30.00;
        $this->productInput->includedKwh = 4000;
        $this->productInput->type = 2;
        $this->assertEquals(800, $this->productInput->getAnnualCost(3500));
        $this->assertEquals(800, $this->productInput->getAnnualCost(4000));
        $this->assertEquals(800.3, $this->productInput->getAnnualCost(4001));
        $this->assertEquals(950, $this->productInput->getAnnualCost(4500));
    }
}
