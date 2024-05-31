<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            [
                'name' => 'Product A',
                'type' => 1,
                'baseCost' => 5,
                'additionalKwhCost' => 22,
            ],
            [
                'name' => 'Product B',
                'type' => 2,
                'baseCost' => 800,
                'additionalKwhCost' => 30,
                'includedKwh' => 4000,
            ]
        ];
        foreach ($data as $item) {
            $product = new Product();
            $product->setName($item['name']);
            $product->setType($item['type']);
            $product->setBaseCost($item['baseCost']);
            $product->setAdditionalKwhCost($item['additionalKwhCost']);
            $product->setIncludedKwh($item['includedKwh'] ?? null);
            $manager->persist($product);
        }

        $manager->flush();    
    }
}
