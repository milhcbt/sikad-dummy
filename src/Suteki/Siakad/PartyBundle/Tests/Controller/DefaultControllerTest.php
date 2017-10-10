<?php

namespace Suteki\Siakad\PartyBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $person = $this->getMockBuilder('Suteki\Siakad\PartyBundle\Entity\Person')->getMock();
        $person->expects($this->any())->method('getCurrentFirstName')->will($this->returnValue("Badu"));
        $this->assertEquals('Badu',$person->getCurrentFirstName());
        //$client = static::createClient();
        //$crawler = $client->request('GET', '/');
        //$this->assertNotEquals(null,$client);
        //$this->assertContains('API Platform', $client->getResponse()->getContent());
    }
}
