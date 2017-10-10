<?php
namespace Suteki\Siakad\AuthBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
* Role untuk akses sistem
* @author iman
* @ORM\Entity
* @ORM\Entity(repositoryClass="Suteki\Siakad\AuthBundle\Repository\RoleRepository")
*/
class Role
{
	/**
	 * @var string $description  deskripsi role
	 * @ORM\Column(length=255)
	 */
	private $description;
	/**
	 * @var array $groups group yang memiliki role ini.
	 * @ORM\ManyToMany(targetEntity="Group", mappedBy="roles")
	 */
	private $groups;
	/**
	 * @var int $id generated  key
     * @ORM\Id
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue(strategy="UUID")
	 */
	private $id;
	/**
	 * @var array $menus menu yang dimiliki role ini.
	 * @ORM\ManyToMany(targetEntity="Menu", inversedBy="roles")
     * @ORM\JoinTable(name="roles_menus")
	 */
	private $menus;
	/**
	 * @var string $name nama role
	 * @ORM\Column(length=50)
	 */
	private $name;

	function __construct()
	{

		$this->groups = new \Doctrine\Common\Collections\ArrayCollection();
		$this->menus = new \Doctrine\Common\Collections\ArrayCollection();
	}

	public static function withNameDesc(String $name,String $description){
		$instance = new Role();
		$instance->name = $name;
		$instance->description = $description;
		return $instance;
    }
    
    public function addMenu(Menu $menu){
        $this->menus->add($menu);
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param array $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getMenus()
    {
        return $this->menus;
    }

    /**
     * @param array $menus
     */
    public function setMenus($menus)
    {
        $this->menus = $menus;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
?>