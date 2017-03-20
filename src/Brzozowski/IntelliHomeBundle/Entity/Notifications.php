<?php

namespace Brzozowski\IntelliHomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notifications
 *
 * @ORM\Table(name="notifications")
 * @ORM\Entity
 */
class Notifications
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Time", type="time", nullable=false)
     */
    private $time;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=10, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="Content", type="string", length=250, nullable=false)
     */
    private $content;

    /**
     * @var boolean
     *
     * @ORM\Column(name="IsRead", type="boolean", nullable=false)
     */
    private $isRead = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="ReadByUser", type="integer", nullable=true)
     */
    private $readByUser;



    function __construct($type, $message)
    {
        $datetime = new \DateTime();
        $this->date = $datetime;
        $this->time = $datetime;
        $this->type = $type;
        $this->content = $message;
        $this->isRead = 0;
        $this->readByUser = 0;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param \DateTime $time
     */
    public function setTime(\DateTime $time)
    {
        $this->time = $time;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return bool
     */
    public function isIsRead()
    {
        return $this->isRead;
    }

    /**
     * @param bool $isRead
     */
    public function setIsRead(bool $isRead)
    {
        $this->isRead = $isRead;
    }

    /**
     * @return int
     */
    public function getReadByUser()
    {
        return $this->readByUser;
    }

    /**
     * @param int $readByUser
     */
    public function setReadByUser(int $readByUser)
    {
        $this->readByUser = $readByUser;
    }


}

