<?php

namespace Suteki\Siakad\AuthBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertNotEquals(null,$client);
        $this->assertContains('API Platform', $client->getResponse()->getContent());
    }
}
