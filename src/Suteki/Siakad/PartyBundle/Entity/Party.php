<?php
namespace Suteki\Siakad\PartyBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Suteki\Siakad\AuthBundle\Entity\User;
/**
 * Party adalah entity generik yang mewakili perorangan atau organisasi, dalam
 * sebuah sistem sering kali penggunaan perorangan dengan organisasi saling
 * menggantikan, oleh karena itu dibutuhkan entity yang bisa mewakili
 * perorangan/organisasi, disinilah peran entity.  Contoh misal vendor, customer,
 * mitra bisa berupa perorangan atau organisasi.
 * ======================
 * @author iman
 * @ORM\Entity(repositoryClass="Suteki\Siakad\PartyBundle\Repository\PartyRepository")
 * @ORM\InheritanceType("JOINED")
 */
class Party
{

	/**
	 * =================================
	 * @var  The entity Id
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="UUID")
	 * @ORM\Column(type="string")
	 */
	private $id;

    /**
	* @var Suteki\Siakad\AuthBundle\Entity\User $user user milik party ini
	* @ORM\OneToOne(targetEntity="Suteki\Siakad\AuthBundle\Entity\User", mappedBy ="party")
	*/
	private $user;

	public function __construct()
	{
	}

	public function getId(){return $this->id;}
	public function getUser(){return $this->user;	}
	public function setUser(User $user){
		$this->user = $user;
		return $this;
	}
	
	/**
	* ini hanya helper kelas data email akan ada di contact mechanism
	*/
	public function getEmail():String {return "someone@acme.com" ;}
	/**
	* ini hanya helper kelas data email akan ada di contact mechanism
	*/
	public function setEmail(String $email) {return $this;}
	/**
	* ini hanya helper kelas data email akan ada di contact mechanism
	*/
	public function getSecondaryEmail():String {return "someone@acme.com" ;}
	/**
	* ini hanya helper kelas data email akan ada di contact mechanism
	*/
	public function setSecondaryEmail(String $email) {return $this;}
}
?>
