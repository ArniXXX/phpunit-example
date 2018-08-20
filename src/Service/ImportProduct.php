<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

/**
 * Class MessageGenerator
 * @package App\Service
 */
class ImportProduct
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    /**
     * @var array
     */
    private $mockBrands = ['Adidas', 'Nike', 'Puma', 'Vans', 'Reebok'];

    /**
     * @var array
     */
    private $mock = [];

    /**
     * MessageGenerator constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        for ($i = 0; $i < 10; $i++) {
            $this->mock[$i]['name'] = $this->mockBrands[array_rand($this->mockBrands)] . ', Model: ' . rand(100, 999);
            $this->mock[$i]['price'] = rand(30, 999);
        }
    }

    /**
     * @return bool
     */
    public function importNewCollection()
    {
        foreach ($this->mock as $item) {
            $product = new Product();

            $product->setName($item['name']);
            $product->setPrice($item['price']);

            $this->entityManager->persist($product);
            $this->entityManager->flush();
        }

        return true;
    }
}