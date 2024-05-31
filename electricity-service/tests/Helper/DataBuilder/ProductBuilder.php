<?php

declare(strict_types=1);

namespace App\Tests\Helper\DataBuilder;

use App\DTO\ProductInput;
use App\DTO\ProductOutput;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Exception\PartialDenormalizationException;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProductBuilder
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function build(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'test 1',
                'type' => 1,
                'baseCost' => 5.00,
                'additionalKwhCost' => 22.00,
                'includedKwh' => null,
            ],
            [
                'id' => 2,
                'name' => 'test 2',
                'type' => 2,
                'baseCost' => 800.00,
                'additionalKwhCost' => 30.00,
                'includedKwh' => 4000,
            ],
        ];
    }

    /**
     * @return ProductInput[]
     *
     * @throws NotNormalizableValueException
     * @throws PartialDenormalizationException
     */
    public static function buildProductInput(): array
    {
        $products = [];
        $normalizer = (new Serializer([new ObjectNormalizer()]));
        foreach (self::build() as $product) {
            $products[] = $normalizer->denormalize($product, ProductInput::class, 'array');
        }

        return $products;
    }

    /**
     * @return ProductOutput[]
     *
     * @throws NotNormalizableValueException
     * @throws PartialDenormalizationException
     */
    public static function buildProductOutput(int $consumption): array
    {
        $products = [];
        foreach (self::buildProductInput() as $product) {
            $products[] = new ProductOutput($product->name, $product->getAnnualCost($consumption));
        }

        return $products;
    }
}
