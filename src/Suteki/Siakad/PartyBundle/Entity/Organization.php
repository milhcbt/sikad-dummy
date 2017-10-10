<?php
namespace Suteki\Siakad\PartyBundle\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * Organisasi yang terlibat dalam sistem.
 * @ORM\Entity(repositoryClass="Suteki\Siakad\PartyBundle\Repository\OrganizationRepository")
 * 
 */
class Organization extends Party
{

	/**
	 * @var String name Organisasi
	 * @ORM\Column(length=100)
	 */
	private $completeName;
	/**
	 * @var String shortName, atau nama sebutan dari organisasi.
	 * @ORM\Column(length=20)
	 */
	private $shortName;

	function __construct()
	{
	}

	public function getCompleteName(){return $this->completeName;}
  public function setCompleteName(String $completeName){
    $this->completeName = $completeName;
	}
	public function getShortName(){return $this->shortName;}
  public function setShortName(String $shortName){
    $this->shortName = $shortName;
  }


}
?>