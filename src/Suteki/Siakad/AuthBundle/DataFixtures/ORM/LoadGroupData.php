<?php
namespace  Suteki\Siakad\AuthBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Suteki\Siakad\AuthBundle\Entity\Group;
use Suteki\Siakad\AuthBundle\Entity\Role;

class LoadGroupData implements FixtureInterface
{
        public function load(ObjectManager $manager)
        {
            $data = new Group();
            $data->setName('Admin');
            $data->setDescription('tukang ngatur web');
            $adminIF = Role::withNameDesc("Admin IF","admin jurusan IF");
            $adminElektro = Role::withNameDesc("Admin Elektro","admin jurusan Elektro");
            $data->addRole($adminIF);
            $data->addRole($adminElektro);
            $manager->persist($adminIF);
            $manager->persist($adminElektro);
            $manager->persist($data);
            $data1 = new Group();
            $data1->setName('Keuangan');
            $KeuAccounting = Role::withNameDesc("Accounting","Bagian Accounting");
            $KeuTreasury = Role::withNameDesc("Treasury","Bagian Treasury");
            $KeuBudget = Role::withNameDesc("Budget","Bagian Budget");
            $KeuInventory = Role::withNameDesc("Inventory & Fixed Asset","Bagian Inventory & Fixed Asset");
            $manager->persist($KeuAccounting);
            $manager->persist($KeuTreasury);
            $manager->persist($KeuBudget);
            $manager->persist($KeuInventory);
            $manager->persist($data1);
            $manager->flush();
        }
        private function getData()
        {
            return [
                ['name' => 'Administrasi',],
                ['name' => 'Keuangan',],
                ['name' => 'Keamanan',],
                ['name' => 'Rektorat',],
                ['name' => 'Akademik',],
                ['name' => 'Koperasi',],
                ['name' => 'Dosen',],
            ];
        }
   
}
