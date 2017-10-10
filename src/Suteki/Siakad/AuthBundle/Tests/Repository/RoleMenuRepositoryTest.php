<?php
// Suteki/Siakad/AuthBundle/Tests/Repository/UserRepositoryTest.php
namespace Suteki\Siakad\AuthBundle\Tests\Repository;

use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\ORM\Tools\SchemaTool;
use Suteki\Siakad\AuthBundle\Entity\Role;
use Suteki\Siakad\AuthBundle\Entity\Menu;
use Symfony\Component\VarDumper\Dumper\CliDumper;

class RoleMenuRepositoryTest extends AuthBundleTest
{

    
    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->loader->loadFromFile(static::$kernel->locateResource(
            '@AuthBundle/DataFixtures/ORM/LoadGroupData.php'));
        $this->loader->loadFromFile(static::$kernel->locateResource(
            '@AuthBundle/DataFixtures/ORM/LoadMenuData.php'));
        // $this->loader->loadFromFile(static::$kernel->locateResource(
        //     '@AuthBundle/DataFixtures/ORM/LoadRoleMenuData.php'));
        $this->executor->execute($this->loader->getFixtures());
    }

    public function testMenuProperties()
    {
        
        $role = $this->em
            ->getRepository(Role::class)
            ->findByName("Admin IF");
        $this->assertGreaterThan(0, $role[0]->getMenus()->count());
    } 
    
    public function testGetMenuTrees(){
         $menu = $this->em->getRepository(Menu::class)
             ->findOneByTitle('UI Elements');
         $children = $menu->getChildren();
         $this->assertGreaterThan(0, count($children));

    }   
}

?>
