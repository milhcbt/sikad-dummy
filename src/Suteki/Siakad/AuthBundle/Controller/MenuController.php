<?php

namespace Suteki\Siakad\AuthBundle\Controller;

use Suteki\Siakad\AuthBundle\Entity\User;
use Suteki\Siakad\AuthBundle\Entity\Menu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
/**
 * Menu controller.
 *
 * @Route("menus")
 */
 class MenuController extends Controller
 {

    private $data;
    private $_user;
    private $_menu;
    /**
    * @Route(
    *     name="app_menu_schema",
    *     path="/schema"
    * )
    * @Method("POST")
    */  
    function schemaAction(Request $request){
        # init
        $em = $this->getDoctrine()->getManager();
        $this->_menu = new Menu;
       

        if ($request->isMethod('POST')) {
            $this->data = json_decode($request->getContent());
        }

        $s_username = $this->data->userName;
        $s_password = $this->data->password;
        $s_email = $this->data->email;

        $errors = array();
        
        if (empty($s_email)) {
            $errors[] = '"email" is required';
        }
        if (empty($s_password)) {
            $errors[] = '"password" is required';
        }
        if (empty($s_username)) {
            $errors[] = '"username" is required';
        }

        $userRepository = $em->getRepository(User::class);

        // make sure we don't already have this user!
        if ($existingUser = $userRepository->findUserByEmail($s_email)) {
            $errors[] = 'A user with this email is already registered!';
        }

        // make sure we don't already have this user!
        if ($existingUser = $userRepository->findUserByUsername($s_username)) {
            $errors[] = 'A user with this username is already registered!';
        }

        if (count($errors) > 0) {
            $return = array(
                'status'=>Response::HTTP_NOT_ACCEPTABLE,
                'errors' => $errors
            );
        }else{

            $this->_user->setUserName($s_username);
            $this->_user->setPassword($s_password);
            $this->_user->setEmail($s_email);
            $em->persist($this->_user);
            $em->flush();

            $return = array(
                'status'=>Response::HTTP_OK,
                'message'=>'User Add Successfully'
            );
        }
 
        $response = new Response(json_encode($return));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
 }