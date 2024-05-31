<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Service\ProductService;
use App\Service\Sorter\ProductSortInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ProductStateProvider implements ProviderInterface
{
    public function __construct(
        private ProductService $productService,
        private RequestStack $request,
        private LoggerInterface $logger,
        private ProductSortInterface $sorter,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        try {
            $consumption = (int) $this->request->getCurrentRequest()->get('consumption');
            $products = $this->productService->get($consumption);

            return $this->sorter->sort($products);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return null;
        }
    }
}
