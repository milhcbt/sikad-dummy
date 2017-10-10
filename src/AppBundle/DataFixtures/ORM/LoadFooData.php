<?php
namespace  AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Foo;

class LoadFooData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = new Foo();
        $data->setBar("bar one");

        $manager->persist($data);
        $manager->flush();
    }
}
