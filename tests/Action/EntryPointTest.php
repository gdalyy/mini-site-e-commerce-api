<?php

namespace App\Tests\Action;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class EntryPointTest
 *
 * @author Daly Ghaith <daly.ghaith@gmail.com>
 */
class EntryPointTest extends WebTestCase
{
    /**
     * @test
     */
    public function test_get_api_documentation()
    {
        $client = static::createClient();

        $client->catchExceptions(false);

        // we expect NotFoundHttpException because we are in "test" env
        $this->expectException(NotFoundHttpException::class);

        $client->request('GET', '/');
    }
}
