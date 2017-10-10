<?php

namespace Suteki\Siakad\AuthBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
     
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();


        $path = self::$kernel->locateResource('@AuthBundle/Tests/Controller/users.json');
        // Go to the list view
        $crawler = $client->request('GET', '/users', array(),
            array(),
            array( 'HTTP_Accept'          => 'application/json'));
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /users/");
        $this->assertJsonStringNotEqualsJsonFile($path,$client->getResponse()->getContent());
    }
}
