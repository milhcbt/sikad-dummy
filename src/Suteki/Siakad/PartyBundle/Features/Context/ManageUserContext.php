<?php
namespace Suteki\Siakad\PartyBundle\Features\Context;

use Behat\Gherkin\Node\PyStringNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Action\UserLogin;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Middleware;
use PHPUnit\Framework\Assert;
use Suteki\Siakad\AuthBundle\Entity\User;

class ManageUserContext implements Context, SnippetAcceptingContext
{
    /**
     * @var ManagerRegistry
     */
     private $doctrine;
     /**
      * @var \Doctrine\Common\Persistence\ObjectManager
      */
     private $manager;
     /**
      * @var SchemaTool
      */
     private $schemaTool;
     /**
      * @var array
      */

     private $newUser;


    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->manager = $doctrine->getManager();

        $this->schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->manager);

        $this->classes = $this->manager->getMetadataFactory()->getAllMetadata();
    }

    /**
     * @BeforeScenario
     */
    public function createSchema()
    {
        $this->schemaTool->dropSchema($this->classes);
        $this->schemaTool->createSchema($this->classes);
    }

        /**
     * @Given Data user baru yang akan dimasukan tersedia dan tidak duplikat dengan data yang telah ada di sistem
     */
     public function dataUserBaruYangAkanDimasukanTersediaDanTidakDuplikatDenganDataYangTelahAdaDiSistem()
     {
        //membuat user baru
        $this->newUser = User::withNamePassEmail("Iman","pass","iman@suteki.co.id");
        $result =  $this->manager->getRepository("Suteki\Siakad\AuthBundle\Entity\User")->findOneBy(array('userName' => 'Iman'));
        Assert::assertNotEquals($this->newUser,$result);
     }
 
     /**
      * @When Memasukan dana user
      */
     public function memasukanDanaUser()
     {
        $this->manager->persist($this->newUser);
        $this->manager->flush();
     }
 
     /**
      * @Then respon :resp
      */
     public function respon($resp)
     {
        $result =  $this->manager->getRepository(User::class)->findOneBy(array('userName' => 'Iman'));
        Assert::assertEquals($this->newUser,$result);
     }

}

?>