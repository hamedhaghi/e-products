<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\QueryParameter;
use App\DTO\ProductOutput;
use App\State\ProductStateProvider;

#[
    ApiResource(
        operations: [
            new GetCollection(
                uriTemplate: '/products',
                provider: ProductStateProvider::class,
                paginationEnabled: false,
                parameters: [
                    'consumption' => new QueryParameter(
                        key: 'consumption',
                        description: 'Electricity consumption (kWh/year)',
                        required: true,
                        schema: [
                            'type' => 'integer',
                            'example' => 1000,
                        ],
                    ),
                ],
                output: ProductOutput::class,
            ),
        ]
    )
]
class Product
{
}
