<?php
/**
 * Created by PhpStorm.
 * User: iman
 * Date: 10/10/2017
 * Time: 7:31 AM
 */

namespace Suteki\Siakad\AuthBundle\Tests\Controller;


use PHPUnit\Framework\TestCase;
use Suteki\Siakad\AuthBundle\Controller\UserManagementController;
use Suteki\Siakad\AuthBundle\Entity\User;
use Suteki\Siakad\AuthBundle\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;

class UserManagementTest extends TestCase
{
    public function testGetUserByUsername()
    {
        $user = User::withNamePassEmail('badu', 'pass', 'badu@acme.com');
        $userRepo = $this->createMock(UserRepository::class);
        $userRepo->expects($this->any())->method('findOneBy')->willReturn($user);

        // Last, mock the EntityManager to return the mock of the repository
        $objectManager = $this->createMock(ObjectManager::class);
        // use getMock() on PHPUnit 5.3 or below
        // $objectManager = $this->getMock(ObjectManager::class);
        $objectManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($userRepo);

//        $umt = new UserManagementController($objectManager);
        $umt = $this->getMockBuilder(UserManagementController::class)
            ->disableOriginalConstructor()
            ->setConstructorArgs($objectManager);


        $this->assertEquals($user, $umt->getUserByUsername('badu'));

    }

}