<?php

declare(strict_types=1);

namespace App\Tests\Unit\State;

use ApiPlatform\Metadata\Operation;
use App\Exception\TariffProviderException;
use App\Service\ProductService;
use App\Service\Sorter\ProductCostSorter;
use App\Service\Sorter\ProductSortInterface;
use App\State\ProductStateProvider;
use App\Tests\Helper\DataBuilder\ProductBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ProductStateProviderTest extends TestCase
{
    protected ProductService|MockObject $productService;
    protected RequestStack|MockObject $requestStack;
    protected Request|MockObject $request;
    protected LoggerInterface|MockObject $logger;
    protected ProductSortInterface|MockObject $sorter;
    protected Operation|MockObject $operation;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productService = $this->createMock(ProductService::class);
        $this->requestStack = $this->createMock(RequestStack::class);
        $this->request = $this->createMock(Request::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->sorter = $this->createMock(ProductSortInterface::class);
        $this->operation = $this->createMock(Operation::class);
    }

    public function testProvideSuccess(): void
    {
        $consumption = 3500;
        $products = ProductBuilder::buildProductOutput($consumption);

        $this->requestStack->expects($this->once())
            ->method('getCurrentRequest')
            ->willReturn($this->request);

        $this->request->expects($this->once())
            ->method('get')
            ->willReturn($consumption);

        $this->productService->expects($this->once())
            ->method('get')
            ->with($consumption)
            ->willReturn($products);

        $sorted = (new ProductCostSorter())->sort($products);

        $this->sorter->expects($this->once())
            ->method('sort')
            ->with($products)
            ->willReturn($sorted);

        $result = (new ProductStateProvider(
            $this->productService,
            $this->requestStack,
            $this->logger,
            $this->sorter,
        ))->provide($this->operation);

        $this->assertIsArray($result);
        $this->assertEquals($sorted, $result);
    }

    public function testProvideReturnsEmptyArrayIfConsumptionIsNull(): void
    {
        $this->requestStack->expects($this->once())
            ->method('getCurrentRequest')
            ->willReturn($this->request);

        $this->request->expects($this->once())
            ->method('get')
            ->willReturn(null);

        $result = (new ProductStateProvider(
            $this->productService,
            $this->requestStack,
            $this->logger,
            $this->sorter,
        ))->provide($this->operation);

        $this->assertEmpty($result);
    }

    public function testProvideReturnsNullIfExceptionThrown(): void
    {
        $consumption = 3500;
        $this->requestStack->expects($this->once())
            ->method('getCurrentRequest')
            ->willReturn($this->request);

        $this->request->expects($this->once())
            ->method('get')
            ->willReturn($consumption);

        $message = 'Unable to fetch tariff provider data';

        $this->productService->expects($this->once())
        ->method('get')
        ->with($consumption)
        ->willThrowException(new TariffProviderException($message));

        $this->logger->expects($this->once())
                ->method('error')
                ->with($message);

        $result = (new ProductStateProvider(
            $this->productService,
            $this->requestStack,
            $this->logger,
            $this->sorter,
        ))->provide($this->operation);

        $this->assertNull($result);
    }
}
