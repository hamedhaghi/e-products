<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\ProductInput;
use App\DTO\ProductOutput;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ProductService
{
    public function __construct(
        private TariffProviderService $tariffProviderService,
        private DenormalizerInterface $denormalizer,
    ) {
    }

    /**
     * @return ProductOutput[]
     *
     * @throws \Exception
     */
    public function get(int $consumption): array
    {
        $tariffs = $this->tariffProviderService->all();
        $products = [];
        foreach ($tariffs as $tariff) {
            /** @var ProductInput $productInput */
            $productInput = $this->denormalizer->denormalize($tariff, ProductInput::class, 'array');
            $products[] = new ProductOutput($productInput->name, $productInput->getAnnualCost($consumption));
        }

        return $products;
    }
}
