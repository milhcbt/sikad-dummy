<?php
namespace Suteki\Siakad\PartyBundle\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * Perorangan yang terlibat dalam sistem.
 * @ORM\Entity(repositoryClass="Suteki\Siakad\PartyBundle\Repository\PersonRepository")
  */
class Person extends Party
{

	/**
	 * @var String Nama Organisasi
	 * @ORM\Column(length=10)
	 */
	private $currentFirstName;
	/**
	 * @var String Singkatan, atau nama sebutan dari organisasi.
	 * @ORM\Column(length=20)
	 */
	private $currentLastName;

	function __construct()
	{
	}

  public static function withFirstLastName(String $currentFirstName,String $currentLastName){
    $instance = new Person();
    $instance->currentFirstName = $currentFirstName;
    $instance->currentLastName = $currentLastName;
    return $instance;
  }

  public function getCurrentFirstName(){return $this->currentFirstName;}
  public function setCurrentFirstName(String $currentFirstName){
    $this->currentFirstName = $currentFirstName;
    return $this;
  }
  public function getCurrentLastName(){return $this->currentLastName;}
  public function setCurrentLastName(String $currentLastName){
    $this->currentLastName = $currentLastName;
    return $this;
  }

}
?>