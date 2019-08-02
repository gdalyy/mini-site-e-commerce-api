<?php

namespace App\Tests\Action\Category;

use App\Entity\Category;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class CategoryProductsListTest
 *
 * @author Daly Ghaith <daly.ghaith@gmail.com>
 */
class CategoryProductsListTest extends WebTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @test
     */
    public function test_get_category_product_list_success()
    {
        $client = static::createClient();

        $category = $this->entityManager
            ->getRepository(Category::class)
            ->findOneBy(['name' => 'Category Test']);

        $client->request('GET', "/api/v1/categories/{$category->getId()}/products");

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $finishedData = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('products', $finishedData['payload']);
        $this->assertEquals(1, count($finishedData['payload']['products']));
    }

    /**
     * @test
     */
    public function test_get_category_product_list_not_found()
    {
        $client = static::createClient();

        $category = $this->entityManager
            ->getRepository(Category::class)
            ->findOneBy(['name' => 'Category Test']);

        $client->request('GET', "/api/v1/categories/100/products");

        $response = $client->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}
