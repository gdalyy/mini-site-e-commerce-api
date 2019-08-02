<?php

namespace App\Tests\Action\Category;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class CategoriesListTest
 *
 * @author Daly Ghaith <daly.ghaith@gmail.com>
 */
class CategoriesListTest extends WebTestCase
{
    /**
     * @test
     */
    public function test_get_categories_list()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/categories/');

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $finishedData = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('categories', $finishedData['payload']);
    }
}
