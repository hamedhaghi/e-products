<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Service\TariffProviderService;
use App\Tests\Helper\DataBuilder\ProductBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class TariffProviderServiceTest extends TestCase
{
    protected HttpClientInterface|MockObject $clientService;
    protected ParameterBagInterface|MockObject $parameterBag;
    protected ResponseInterface|MockObject $response;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientService = $this->createMock(HttpClientInterface::class);
        $this->parameterBag = $this->createMock(ParameterBagInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);
    }

    public function testAll(): void
    {
        $products = ProductBuilder::build();

        $this->parameterBag->expects($this->once())
            ->method('get')
            ->withAnyParameters()
            ->willReturn('http://example.com');

        $this->response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(Response::HTTP_OK);

        $this->response->expects($this->once())
            ->method('toArray')
            ->willReturn($products);

        $this->clientService->expects($this->once())
            ->method('request')
            ->withAnyParameters()
            ->willReturn($this->response);

        $service = new TariffProviderService(
            $this->clientService,
            $this->parameterBag,
        );

        $this->assertEquals($products, $service->all());
    }
}
