<?php

namespace App\Tests\Action\Product;

use App\Entity\Category;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class CreateProductTest
 *
 * @author Daly Ghaith <daly.ghaith@gmail.com>
 */
class CreateProductTest extends WebTestCase
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
    public function test_post_product_success()
    {
        $client = static::createClient();

        $category = $this->entityManager
            ->getRepository(Category::class)
            ->findOneBy(['name' => 'Category Test']);

        $client->request('POST', '/api/v1/products/', [], [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'name' => 'Product Test',
                'price' => [
                    "amount" => 10,
                    "currency" => "EUR"
                ],
                'quantity' => 5,
                'categories' => [
                    $category->getId()
                ]
            ])
        );

        $response = $client->getResponse();

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    /**
     * @test
     */
    public function test_post_product_validation_failed()
    {
        $client = static::createClient();

        $category = $this->entityManager
            ->getRepository(Category::class)
            ->findOneBy(['name' => 'Category Test']);

        // test NotBlank Constraint on name, amount, currency & Min Constraint on categories
        $client->request('POST', '/api/v1/products/', [], [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'name' => '',
                'price' => [
                    'amount' => '',
                    'currency' => ''
                ],
                'quantity' => 5,
                'categories' => [
                ]
            ])
        );

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $finishedData = json_decode($response->getContent(), true);

        $this->assertNotEmpty($finishedData['errors']['children']['name']);
        $this->assertNotEmpty($finishedData['errors']['children']['price']['children']['amount']);
        $this->assertNotEmpty($finishedData['errors']['children']['price']['children']['currency']);
        $this->assertNotEmpty($finishedData['errors']['children']['categories']);

        // test UniqueEntity Constraint on name field

        $client->request('POST', '/api/v1/products/', [], [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'name' => 'Product Test',
                'price' => [
                    'amount' => 10,
                    'currency' => 'EUR'
                ],
                'quantity' => 5,
                'categories' => [
                    $category->getId()
                ]
            ])
        );

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $finishedData = json_decode($response->getContent(), true);

        $this->assertNotEmpty($finishedData['errors']['children']['name']);
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
