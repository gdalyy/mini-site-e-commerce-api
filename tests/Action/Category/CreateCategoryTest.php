<?php

namespace App\Tests\Action\Category;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class CreateCategoryTest
 *
 * @author Daly Ghaith <daly.ghaith@gmail.com>
 */
class CreateCategoryTest extends WebTestCase
{
    /**
     * @test
     */
    public function test_post_category_success()
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/categories/', [], [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'name' => 'Category Test'
            ])
        );

        $response = $client->getResponse();

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    /**
     * @test
     */
    public function test_post_category_validation_failed()
    {
        $client = static::createClient();

        // test NotBlank Constraint
        $client->request('POST', '/api/v1/categories/', [], [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'name' => '',
            ])
        );

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $finishedData = json_decode($response->getContent(), true);

        $this->assertNotEmpty($finishedData['errors']['children']['name']);

        // test UniqueEntity Constraint on name field

        $client->request('POST', '/api/v1/categories/', [], [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'name' => 'Category Test',
            ])
        );

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $finishedData = json_decode($response->getContent(), true);

        $this->assertNotEmpty($finishedData['errors']['children']['name']);
    }
}
