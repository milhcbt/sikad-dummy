<?php
namespace Suteki\Siakad\AuthBundle\Controller;

use Suteki\Siakad\AuthBundle\Entity\User;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserManagementController  extends Controller
{
    private $om;

    public function __construct()
    {
        $em = $this->getDoctrine()->getManager();
    }

//    public function __construct(ObjectManager $objectManager)
//    {
//        $this->om = $objectManager;
//    }

    public function getUserByUsername ($userName)
    {
        return $this->om->getRepository(User::class)->findOneBy(
            array('userName' => $userName)
        );
    }
}