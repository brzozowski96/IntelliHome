<?php

namespace Brzozowski\IntelliHomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HeatingStatistics
 *
 * @ORM\Table(name="heating_statistics")
 * @ORM\Entity
 */
class HeatingStatistics
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
     * @var float
     *
     * @ORM\Column(name="Temperature", type="float", precision=10, scale=0, nullable=false)
     */
    private $temperature;

    /**
     * @var integer
     *
     * @ORM\Column(name="Humidity", type="integer", nullable=false)
     */
    private $humidity;

    /**
     * @var float
     *
     * @ORM\Column(name="SetTemp", type="float", precision=10, scale=0, nullable=false)
     */
    private $setTemp;

    /**
     * @var float
     *
     * @ORM\Column(name="FromTemp", type="float", precision=10, scale=0, nullable=false)
     */
    private $fromTemp;

    /**
     * @var float
     *
     * @ORM\Column(name="ToTemp", type="float", precision=10, scale=0, nullable=false)
     */
    private $toTemp;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return HeatingStatistics
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     *
     * @return HeatingStatistics
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set temperature
     *
     * @param float $temperature
     *
     * @return HeatingStatistics
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;

        return $this;
    }

    /**
     * Get temperature
     *
     * @return float
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * Set humidity
     *
     * @param integer $humidity
     *
     * @return HeatingStatistics
     */
    public function setHumidity($humidity)
    {
        $this->humidity = $humidity;

        return $this;
    }

    /**
     * Get humidity
     *
     * @return integer
     */
    public function getHumidity()
    {
        return $this->humidity;
    }

    /**
     * Set setTemp
     *
     * @param float $setTemp
     *
     * @return HeatingStatistics
     */
    public function setSetTemp($setTemp)
    {
        $this->setTemp = $setTemp;

        return $this;
    }

    /**
     * Get setTemp
     *
     * @return float
     */
    public function getSetTemp()
    {
        return $this->setTemp;
    }

    /**
     * Set fromTemp
     *
     * @param float $fromTemp
     *
     * @return HeatingStatistics
     */
    public function setFromTemp($fromTemp)
    {
        $this->fromTemp = $fromTemp;

        return $this;
    }

    /**
     * Get fromTemp
     *
     * @return float
     */
    public function getFromTemp()
    {
        return $this->fromTemp;
    }

    /**
     * Set toTemp
     *
     * @param float $toTemp
     *
     * @return HeatingStatistics
     */
    public function setToTemp($toTemp)
    {
        $this->toTemp = $toTemp;

        return $this;
    }

    /**
     * Get toTemp
     *
     * @return float
     */
    public function getToTemp()
    {
        return $this->toTemp;
    }
}
