<?php

declare(strict_types=1);

namespace App\Tests\API;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ProductTest extends ApiTestCase
{
    public function testGetProductsSuccess(): void
    {
        $client = static::createClient();
        $response = $client->request('GET', '/api/products', [
            'query' => [
                'consumption' => 3500,
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
    }

    public function testGetProductsWithoutConsumptionFail(): void
    {
        static::createClient()->request('GET', '/api/products');
        $this->assertResponseIsUnprocessable();
    }
}
