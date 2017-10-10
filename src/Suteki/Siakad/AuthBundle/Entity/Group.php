<?php

namespace Suteki\Siakad\AuthBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @author iman
 * 
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Suteki\Siakad\AuthBundle\Repository\GroupRepository")
 * @ORM\Table(name="`group`")
 */
class Group
{
	/**
	 * @var string $description deskripsi dari group, min = 0, max = 100
	 * @ORM\Column(length=100,nullable=true)
	 */
	private $description;

	/**
	 * @var int $id generated key
     * @ORM\Id
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     */
	private $id;
	/**
	 * @var string $name nama group, misal manajemen, rektorat, administrasi, keamanan
	 * dll. min = 3, max = 20
	 * @ORM\Column(length=20,nullable=false)
	 */
	private $name;
	/**
	 * @var array $roles Role yang dimilik group.
	 * @ORM\ManyToMany(targetEntity="Role", inversedBy="groups")
     * @ORM\JoinTable(name="groups_roles")
	 */
	private $roles;
	/**
	 * @var array $users anggota group.
	 * @ORM\ManyToMany(targetEntity="User", mappedBy="groups")
	 */
	private $users;

	function __construct()
	{
		$this->roles = new ArrayCollection();
	}

	public static function withName(string $name)
	{
        $instance = new Group();
        $instance->name = $name;
        return $instance;
	}

	public function addRole(Role $role){
		$this->roles->add($role);
	}
	
	public function getId(){return $this->id;}
	public function setName(String $name){
	    $this->name = $name;
	    return $this;
	}
	public function getName(){return $this->name;}
    public function getRoles(){return $this->roles;}
    public function setRoles(ArrayCollection $roles){
        $this->roles = $roles;
    }
    public function getUsers(){return $this->users;}
    public function setUsers(ArrayCollection $users){
        $this->users = $users;
    }
    public function getDescription(){return $this->description;}
    public function setDescription(String $description){
        $this->description = $description;
    }
   
}
?>
