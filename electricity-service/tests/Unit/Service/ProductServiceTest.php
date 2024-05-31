<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Service\ProductService;
use App\Service\TariffProviderService;
use App\Tests\Helper\DataBuilder\ProductBuilder;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ProductServiceTest extends TestCase
{
    public function testGet(): void
    {
        $products = ProductBuilder::build();
        $tariffProviderService = $this->createMock(TariffProviderService::class);
        $denormalizer = $this->createMock(DenormalizerInterface::class);
        $tariffProviderService->expects($this->once())
            ->method('all')
            ->willReturn($products);

        $consumption = 3500;
        $products = ProductBuilder::buildProductOutput($consumption);

        $denormalizer->expects($this->exactly(2))
            ->method('denormalize')
            ->withAnyParameters()
            ->willReturnOnConsecutiveCalls(...ProductBuilder::buildProductInput());

        $service = new ProductService($tariffProviderService, $denormalizer);
        $result = $service->get($consumption);

        $this->assertEquals($products, $result);
    }
}
