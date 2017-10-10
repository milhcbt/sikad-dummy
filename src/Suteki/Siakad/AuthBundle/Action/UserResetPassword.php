<?php
// src/Suteki/Siakad/AuthBundle/Action/UserResetPassword.php

namespace Suteki\Siakad\AuthBundle\Action;

use Suteki\Siakad\AuthBundle\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserResetPassword
{
    private $failMessage = 'Invalid reset password';

    /**
     * @Route(
     *     name="app_user_reset_password",
     *     path="/user/reset_password",
     *     defaults={"_api_resource_class"=Suteki\Siakad\AuthBundle\Entity\User::class,"_api_item_operation_name"="reset_password"}
     * )
     * @Method("POST")
     */  
    public function __invoke(Request $request) // 
    {
        // if ($request->getPathInfo() != '/user/reset_password' || !$request->isMethod('POST')) {
      	// 	return;
    	// }
         // jika content request berupa json
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());
        }

        $username = $request->request->get('username');
    	$email = $request->request->get('email');
        $captcha = $request->request->get('captcha');
      
        ## note : bagian untuk dihubungkan ke entity
        ## begin

        ## end

        if($username != '' && $email != '' && $captcha != '')
        {
            $return = array(
                "apiVersion"=>"1.0",
                "data"=>array(
                    "code"=>200,
                    "title"=>"Success",
                    "message"=>"Reset password success!"
                )
            );

        }else{
            $return = array(
                "apiVersion"=>"1.0",
                "error"=>array(
                    "code"=>400,
                    "title"=>"An error occurred",
                    "message"=>$this->failMessage
                )
            );
        }

        $response = new Response(json_encode($return));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}