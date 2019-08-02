<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Price;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Intl\Currencies;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = array();

        // adding categories fixtures
        for ($i = 0; $i < 10; $i++) {
            $category = new Category();

            $category->setName("Test Category {$i}");
            $manager->persist($category);

            $categories[] = $category;
        }

        //adding products fixtures
        for ($i = 0; $i < 100; $i++) {
            $product = new Product();
            $product
                ->setName("Test Product {$i}")
                ->setPrice((new Price())
                    ->setAmount(rand(1, 1000))
                    ->setCurrency(Currencies::getCurrencyCodes()[array_rand(Currencies::getCurrencyCodes())])
                )
                ->setQuantity(rand(1, 100));

            for ($j = 0; $j <= rand(2, 10); $j++) {
                $product->addCategory($categories[rand(0,9)]);
            }

            $manager->persist($product);
        }

        $manager->flush();
    }
}
