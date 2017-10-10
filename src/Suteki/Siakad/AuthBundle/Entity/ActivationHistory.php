<?php


namespace Suteki\Siakad\AuthBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author iman
 * @ORM\Entity
 */
class ActivationHistory
{
	/**
	 * @var timestamp $historyTime kapan waktu perubahan terjadi.
	 * @ORM\Column(type="datetime",nullable = false) 
	 */
	private $historyTime;
	/**
	 * @var int $id generate id.
     * @ORM\Id
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue(strategy="UUID")
	 */
    private $id;
    
	/**
	 * @var string $notes catatan perubahan  status activasi user, misal user di
	 * suspend, user diaktifkan kembali dll.
	 * @ORM\Column(length=255,nullable = false) 
	 */
	private $notes;
	/**
	 * @var User $user   User pemilik history
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="activationHistory")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
	private $user;

	function __construct()
	{
	}

    /**
     * @return timestamp
     */
    public function getHistoryTime()
    {
        return $this->historyTime;
    }

    /**
     * @param timestamp $historyTime
     */
    public function setHistoryTime($historyTime)
    {
        $this->historyTime = $historyTime;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
?>