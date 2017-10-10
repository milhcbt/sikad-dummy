<?php
namespace  Suteki\Siakad\AuthBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Suteki\Siakad\AuthBundle\Entity\User;

class LoadUserData implements FixtureInterface{
    public function load(ObjectManager $manager){
       
        $data = $this->getData();  
        
        for($i=0;$i<count($data);$i++) {
            $raws = User::withNamePassEmail($data[$i]['userName'],$data[$i]['password'],$data[$i]['email']);
            $raws->setQuestionOne($data[$i]['questionOne']);
            $raws->setQuestionTwo($data[$i]['questionTwo']);
            $raws->setQuestionTree($data[$i]['questionTree']);
            $raws->setAnswerOne($data[$i]['answerOne']);
            $raws->setAnswerTwo($data[$i]['answerTwo']);
            $raws->setAnswerTree($data[$i]['answerTree']);
            $manager->persist($raws);
            $manager->flush();
        }
         
    }

    private function getData(){
        return [
            ['userName' => 'badu','password'=>'password','email'=>'badu@localhost.com',
            'answerOne'=>'yes','answerTwo'=>'yes','answerTree'=>'yes',
            'questionOne'=>'are u human','questionTwo'=>'are u human','questionTree'=>'are u human'],
            ['userName' => 'budi','password'=>'password','email'=>'budi@localhost.com',
            'answerOne'=>'yes','answerTwo'=>'yes','answerTree'=>'yes',
            'questionOne'=>'are u human','questionTwo'=>'are u human','questionTree'=>'are u human'],
            ['userName' => 'bona','password'=>'password','email'=>'bona@localhost.com',
            'answerOne'=>'yes','answerTwo'=>'yes','answerTree'=>'yes',
            'questionOne'=>'are u human','questionTwo'=>'are u human','questionTree'=>'are u human'],
            ['userName' => 'boni','password'=>'password','email'=>'boni@localhost.com',
            'answerOne'=>'yes','answerTwo'=>'yes','answerTree'=>'yes',
            'questionOne'=>'are u human','questionTwo'=>'are u human','questionTree'=>'are u human'],
        ];
    }
}