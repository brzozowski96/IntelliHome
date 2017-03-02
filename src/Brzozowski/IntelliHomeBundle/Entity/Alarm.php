<?php

namespace Brzozowski\IntelliHomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alarm
 *
 * @ORM\Table(name="alarm")
 * @ORM\Entity
 */
class Alarm
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
     * @var integer
     *
     * @ORM\Column(name="Who", type="integer", nullable=true)
     */
    private $who;

    /**
     * @var string
     *
     * @ORM\Column(name="Status", type="string", length=10, nullable=false)
     */
    private $status;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
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
    public function getTime(): \DateTime
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
     * @return int
     */
    public function getWho(): int
    {
        return $this->who;
    }

    /**
     * @param int $who
     */
    public function setWho(int $who)
    {
        $this->who = $who;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }


}

