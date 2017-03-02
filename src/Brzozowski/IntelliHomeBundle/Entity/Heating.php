<?php

namespace Brzozowski\IntelliHomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Heating
 *
 * @ORM\Table(name="heating")
 * @ORM\Entity
 */
class Heating
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
     * @ORM\Column(name="OperatingMode", type="integer", nullable=false)
     */
    private $operatingMode;

    /**
     * @var float
     *
     * @ORM\Column(name="Temperature", type="float", precision=10, scale=0, nullable=false)
     */
    private $temperature;

    /**
     * @var float
     *
     * @ORM\Column(name="Amplitude", type="float", precision=10, scale=0, nullable=false)
     */
    private $amplitude;

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
    public function getOperatingMode(): int
    {
        return $this->operatingMode;
    }

    /**
     * @param int $operatingMode
     */
    public function setOperatingMode(int $operatingMode)
    {
        $this->operatingMode = $operatingMode;
    }

    /**
     * @return float
     */
    public function getTemperature(): float
    {
        return $this->temperature;
    }

    /**
     * @param float $temperature
     */
    public function setTemperature(float $temperature)
    {
        $this->temperature = $temperature;
    }

    /**
     * @return float
     */
    public function getAmplitude(): float
    {
        return $this->amplitude;
    }

    /**
     * @param float $amplitude
     */
    public function setAmplitude(float $amplitude)
    {
        $this->amplitude = $amplitude;
    }


}

