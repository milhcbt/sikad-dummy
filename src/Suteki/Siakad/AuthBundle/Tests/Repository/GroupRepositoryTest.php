<?php
// Suteki/Siakad/AuthBundle/Tests/Repository/UserRepositoryTest.php
namespace Suteki\Siakad\AuthBundle\Tests\Repository;

use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\ORM\Tools\SchemaTool;
use Suteki\Siakad\AuthBundle\Entity\Group;

class GroupRepositoryTest extends AuthBundleTest
{

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->loader->loadFromFile(static::$kernel->locateResource('@AuthBundle/DataFixtures/ORM/LoadGroupData.php'));
        $this->executor->execute($this->loader->getFixtures());
    }

    public function testGroupProperties()
    {
        
        $group = $this->em
            ->getRepository(Group::class)
            ->findByName("Admin");
        $this->assertEquals("tukang ngatur web", $group[0]->getDescription());
    }    
}

?>
