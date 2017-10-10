<?php

namespace Suteki\Siakad\AuthBundle\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Suteki\Siakad\PartyBundle\Entity\Party;
use Doctrine\Common\Collections\ArrayCollection;
use \DateTime;


/**
 * @author iman
 * @ORM\Entity(repositoryClass="Suteki\Siakad\AuthBundle\Repository\UserRepository")
 * @ORM\Table(name="`user`")
 * 
 */

class User
{
	/**
	 * @var int $id generated primary key
     * @ORM\Id
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     */
	 protected $id;
	
	/**
	 * @var array $activationHistory riwayat perubahan status activasi user.
	 * @ORM\OneToMany(targetEntity="ActivationHistory", mappedBy="user")
	 */
	private $activationHistory;
	
	/**
	 * @var boolean $active apakah account user active (boleh login atau tidak)
	 * historynya di simpan di Activation History.
	 * @ORM\Column(type= "boolean")
	 */
	private $active=false;
	
	
	/** @var timestamp $dueDate sampai kapan user account ini akan berlaku, untuk
		 * mahasiswa misal lama pendidikan max 7 tahun, maka saat dibuat due date otomatis
		 * diisi tanggal 7 tahun kedepan. bisa juga dibuat kebijakan account akan direview
		 * 1 tahun sekali atau 3 bulan sekali.
		 * @ORM\Column(type= "datetime")
		 */
	private $dueDate;
	
	
	/**
	 * @var array $groups seorang user bisa masuk kelebih dari satu group.
	 * @ORM\ManyToMany(targetEntity="Group", inversedBy="users")
 	 * @ORM\JoinTable(name="users_groups")
	 */
	private $groups;	
	
	/**
	 * @var int $party  party terkait  
	 * @ORM\OneToOne(targetEntity="Suteki\Siakad\PartyBundle\Entity\Party", inversedBy ="user",  cascade={"persist", "remove"})
	 * @ORM\JoinColumn(name="party_id", referencedColumnName="id")
	 */
	protected $party;
	
	
	/**
	 * @var string $password   password encripted.
	 * @ORM\Column(length=140)
	 */
	protected $password;
	
	
	/** @var string $userName user untuk login, untuk nama lengkap dll ada di entity
	 * lain.
	 * @ORM\Column(length=50,nullable=false,unique=true)
	 */
	protected $userName;
	
	
	/**
	* @var string $answerOne jawaban untuk pertanyaan ke-satu, min = 0, max = 100.
	* @ORM\Column(length=100)
	*/
	private $answerOne;
	
	
	/**
	* @var string $answerTree jawaban untuk pertanyaan ke-tiga, min = 0, max = 100
	* @ORM\Column(length=100)
	*/
	private $answerTree;
	
	
	/**
	* @var string $answerTwo jawaban untuk pertanyaan ke-dua, min = 0, max = 100
	* @ORM\Column(length=100)
	*/
	private $answerTwo;
	
	
	/**
    * @var string $questionOne Pertanyaan untuk keamanan, jika lupa password dll, min
	* @ORM\Column(length=100)
	*/
	private $questionOne;
	
	
	/**
	* @var string $questionTree Pertanyaan untuk keamanan, jika lupa password dll,
	* @ORM\Column(length=100)
	*/
	private $questionTree;
	
	/**
	* @var string $questionTwo Pertanyaan untuk keamanan, jika lupa password dll, min
	* @ORM\Column(length=100)
	*/
	private $questionTwo;
	
	/**
	* @var string $salt salt untuk enkripsi password user.
	* @ORM\Column(length=100,nullable=true)
    */
	private $salt;
	
	function __construct()
	{

		$this->groups = new ArrayCollection();
        $this->activationHistory = new ArrayCollection();
        // date_default_timezone_set('Asia/Jakarta');
        $this->dueDate = new DateTime('now') ;
        $this->party = new Party();//TODO: fix it, harusnya gak langsung seperti ini, hanya sementara supaya bisa get/set email.
		
	}
	
	function __destruct()
	{

	}

	static function withNamePassEmail($name, $pass, $email){
	    $instance = new User();
	    $instance->userName = $name;
	    $instance->password = $pass;
        $instance->setEmail($email);
        $instance->setQuestionOne('questionOne');
        $instance->setQuestionTwo('questionTwo');
        $instance->setQuestionTree('questionTree');
        $instance->setAnswerOne('answerOne');
        $instance->setAnswerTwo('answerTwo');
        $instance->setAnswerTree('answerTree');
	    return $instance;
	}

	static function withNamePass($name, $pass){
	    $instance = User::withNamePassEmail($name,$pass);
	    $instance->setEmail('user@acme.com');
	    return $instance;
	}

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return array
     */
    public function getActivationHistory()
    {
        return $this->activationHistory;
    }

    /**
     * @param array $activationHistory
     * @return User
     */
    public function setActivationHistory($activationHistory)
    {
        $this->activationHistory = $activationHistory;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return timestamp
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param timestamp $dueDate
     * @return User
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
        return $this;
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
     * @return User
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
        return $this;
    }

    /**
     * @return int
     */
    public function getParty()
    {
        return $this->party;
    }

    /**
     * @param int $party
     * @return User
     */
    public function setParty($party)
    {
        $this->party = $party;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     * @return User
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
        return $this;
    }

    /**
     * @return string
     */
    public function getAnswerOne()
    {
        return $this->answerOne;
    }

    /**
     * @param string $answerOne
     * @return User
     */
    public function setAnswerOne($answerOne)
    {
        $this->answerOne = $answerOne;
        return $this;
    }

    /**
     * @return string
     */
    public function getAnswerTree()
    {
        return $this->answerTree;
    }

    /**
     * @param string $answerTree
     * @return User
     */
    public function setAnswerTree($answerTree)
    {
        $this->answerTree = $answerTree;
        return $this;
    }

    /**
     * @return string
     */
    public function getAnswerTwo()
    {
        return $this->answerTwo;
    }

    /**
     * @param string $answerTwo
     * @return User
     */
    public function setAnswerTwo($answerTwo)
    {
        $this->answerTwo = $answerTwo;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuestionOne()
    {
        return $this->questionOne;
    }

    /**
     * @param string $questionOne
     * @return User
     */
    public function setQuestionOne($questionOne)
    {
        $this->questionOne = $questionOne;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuestionTree()
    {
        return $this->questionTree;
    }

    /**
     * @param string $questionTree
     * @return User
     */
    public function setQuestionTree($questionTree)
    {
        $this->questionTree = $questionTree;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuestionTwo()
    {
        return $this->questionTwo;
    }

    /**
     * @param string $questionTwo
     * @return User
     */
    public function setQuestionTwo($questionTwo)
    {
        $this->questionTwo = $questionTwo;
        return $this;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }


    /**
     * method ini hanya helper data sebenarnya ada di party mechanism.
     * @return string
     */
     public function getEmail()
     {
         return $this->party->getEmail();
     }
 
     /**
      * method ini hanya helper data sebenarnya ada di party mechanism.
      * @param string $email
      * @return User
      */
     public function setEmail($email)
     {
         $this->party->setEmail($email);
         return $this;
     }

     
    /**
     * method ini hanya helper data sebenarnya ada di party mechanism.
     * @return string
     */
    public function getSecondaryEmail()
    {
        return $this->party->getSecondaryEmail();
    }

    /**
     * method ini hanya helper data sebenarnya ada di party mechanism.
     * @param string $email
     * @return User
     */
    public function setSecondaryEmail($email)
    {
        $this->party->setSecondaryEmail($email);
        return $this;
    }


}

?>
