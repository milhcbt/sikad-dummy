<?php

namespace Suteki\Siakad\AuthBundle\Action;

use Symfony\Component\HttpFoundation\JsonResponse;
use Suteki\Siakad\AuthBundle\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;

class LoginAction
{
    private $myService;

    public function __construct()
    {
        // $this->myService = $myService;
    }

    /**
     * @Route("/users/{id}/login",
     *     name="users_login",
     *     methods = {"POST"},
     *     defaults={"_api_resource_class"=User::class, "_api_item_operation_name"="login"}
     *     )
     */
    public function __invoke($id=0,User $data) // API Platform retrieves the PHP entity using the data provider then (for POST and
                                    // PUT method) deserializes user data in it. Then passes it to the action. Here $data
                                    // is an instance of user having the given ID. By convention, the action's parameter
                                    // must be called $data.
    {
        // $this->myService->doSomething($data);
//        var_dump($data);

        return $data; // API Platform will automatically validate, persist (if you use Doctrine) and serialize an entity
                      // for you. If you prefer to do it yourself, return an instance of Symfony\Component\HttpFoundation\Response
    }
}
