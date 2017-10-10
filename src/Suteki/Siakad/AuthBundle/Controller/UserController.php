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
 * User controller.
 *
 * @Route("user")
 */
class UserController extends Controller
{
    private $data;
    private $_user ;

    public function __construct() {
       
    }
    
    /**
     * @Route(
     *     name="app_user_login",
     *     path="/login"
     * )
     * @Method("POST")
     */  
    public function loginAction(Request $request)
    {
        # init
        $em = $this->getDoctrine()->getManager();

        if ($request->isMethod('POST')) {
            $this->data = json_decode($request->getContent());
        }

        # lakukan validasi request    
        if(empty($this->data)){
            $return = array("error"=>Response::HTTP_NO_CONTENT,"error_description"=>"Invalid request!");
        }
        else
        {
            $s_username = $this->data->userName;
            $s_password = $this->data->password;
           
            if(!empty($s_username) and !empty($s_password))
            {
                $this->_user =  $em->getRepository(User::class)->findOneBy(
                    array('userName' => $s_username, 'password' => $s_password)
                );
                if(empty($this->_user)) {
                    $return = array("error"=>Response::HTTP_NOT_FOUND,"error_description"=>"user not found");
                }else{
                    $return = $em->getRepository(Menu::class)->findAll();
                }
               
            }else{
                $return = array("error"=>Response::HTTP_NOT_ACCEPTABLE,"error_description"=>"Invalid request!");
            }
        }
        
        $response = new Response(json_encode($return));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
    
    /**
     * @Route(
     *     name="app_user_register",
     *     path="/register"
     * )
     * @Method("POST")
     */  
    public function registerAction(Request $request){
        # init
        $em = $this->getDoctrine()->getManager();
        $this->_user = new User;
       

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

    /**
     * @Route(
     *     name="app_user_reset_password_request",
     *     path="/reset_password/request",
     * )
     * @Method("POST")
     */  
    public function resetPasswordRequestAction(Request $request){

        # init
        $em = $this->getDoctrine()->getManager();
        $this->_user = new User;

        if ($request->isMethod('POST')) {
            $this->data = json_decode($request->getContent());
        }

        $s_email = $this->data->email;
        
        $errors = array();
        
        if (empty($s_email)) {
            $errors[] = '"email" is required';
        }

        $userRepository = $em->getRepository(User::class);
        
        // make sure we don't already have this user!
        if (!$existingUser = $userRepository->findUserByEmail($s_email)) {
            $errors[] = 'A user with this email does not exist or registered!';
        }

        if (count($errors) > 0) {
            $return = array(
                'status'=>Response::HTTP_NOT_ACCEPTABLE,
                'errors' => $errors
            );
        }else{
            $return = array(
                'status'=>Response::HTTP_OK,
                'url_direct'=>'/reset_password',
                'message'=>'An email has been sent. It contains a link you must click to reset your password.'
            );
        }
        
        $response = new Response(json_encode($return));
        $response->headers->set('Content-Type', 'application/json');

        return $response;


    }

    /**
     * @Route(
     *     name="app_user_reset_password",
     *     path="/reset_password",
     * )
     * @Method("POST")
     */  
     public function resetPasswordAction(Request $request){
        
        # init
        $em = $this->getDoctrine()->getManager();
        $this->_user = new User;

        if ($request->isMethod('POST')) {
            $this->data = json_decode($request->getContent());
        }

        $s_email            = $this->data->email;
        $s_first_password   = $this->data->firstPassword;
        $s_second_password  = $this->data->secondPassword;
        
        $errors = array();
        
        if (empty($s_email)) {
            $errors[] = '"email" is required';
        }
        if (empty($s_first_password)) {
            $errors[] = 'first new "password" is required';
        }
        if (empty($s_second_password)) {
            $errors[] = 'second new "password" is required';
        }

        $userRepository = $em->getRepository(User::class);
        
        // make sure we don't already have this user!
        if ($existingUser = $userRepository->findUserByEmail($s_email)) {
            $errors[] = 'A user with this email does not exist or registered!';
        }

        if (count($errors) > 0) {
            $return = array(
                'status'=>Response::HTTP_NOT_ACCEPTABLE,
                'errors' => $errors
            );
        }else{

            // $this->_user = $em->getRepository(User::class)->findBy(array('email'=>$s_email));
            $this->_user = $em->createQuery(
                'SELECT u FROM AuthBundle:User u '
            )
            ->Where('u.email=:=mail')
            ->setParameter('mail',$s_email)
            ->getResult();
            var_dump($this->_user);

            if(empty($this->_user))
            {
                $return = array(
                    'status'=>Response::HTTP_NOT_FOUND,
                    'errors' => 'user not found'
                ); 
            }else{

                    $this->_user->setPassword($s_first_password);
                    $em->persist($this->_user);
                    $em->flush();

                    $return = array(
                        'status'=>Response::HTTP_OK,
                        'message'=>'Reset password success'
                    );
            }
        }
        
        $response = new Response(json_encode($return));
        $response->headers->set('Content-Type', 'application/json');

        return $response;


    }
}
