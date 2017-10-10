<?php
namespace  Suteki\Siakad\PartyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Suteki\Siakad\PartyBundle\Entity\Party;

class LoadPartyData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $party = new Party();

        $manager->persist($party);
        $manager->flush();
    }
}
