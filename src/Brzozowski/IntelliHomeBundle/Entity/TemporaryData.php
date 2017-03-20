<?php

namespace Brzozowski\IntelliHomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TemporaryData
 *
 * @ORM\Table(name="temporary_data")
 * @ORM\Entity(repositoryClass="TemporaryDataRepository")
 */
class TemporaryData
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
     * @var integer
     *
     * @ORM\Column(name="Insolation", type="integer", nullable=false)
     */
    private $insolation;

    /**
     * @var integer
     *
     * @ORM\Column(name="WindLevel", type="integer", nullable=false)
     */
    private $windlevel;

    /**
     * @var integer
     *
     * @ORM\Column(name="RainLevel", type="integer", nullable=false)
     */
    private $rainlevel;

    /**
     * @var integer
     *
     * @ORM\Column(name="Pressure", type="integer", nullable=false)
     */
    private $pressure;

    /**
     * @var integer
     *
     * @ORM\Column(name="LiquidWaste", type="integer", nullable=false)
     */
    private $liquidwaste;

    /**
     * @var float
     *
     * @ORM\Column(name="HomeTemperature", type="float", precision=10, scale=0, nullable=false)
     */
    private $hometemperature;

    /**
     * @var integer
     *
     * @ORM\Column(name="HomeHumidity", type="integer", nullable=false)
     */
    private $homehumidity;

    /**
     * @var integer
     *
     * @ORM\Column(name="BlindLevel", type="integer", nullable=false)
     */
    private $blindlevel;

    /**
     * @var integer
     *
     * @ORM\Column(name="HeatingLevel", type="integer", nullable=false)
     */
    private $heatinglevel;

    /**
     * @var boolean
     *
     * @ORM\Column(name="WateringState", type="boolean", nullable=false)
     */
    private $wateringstate;



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
     * @return TemporaryData
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
     * @return TemporaryData
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
     * @return TemporaryData
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
     * @return TemporaryData
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
     * Set insolation
     *
     * @param integer $insolation
     *
     * @return TemporaryData
     */
    public function setInsolation($insolation)
    {
        $this->insolation = $insolation;

        return $this;
    }

    /**
     * Get insolation
     *
     * @return integer
     */
    public function getInsolation()
    {
        return $this->insolation;
    }

    /**
     * Set windlevel
     *
     * @param integer $windlevel
     *
     * @return TemporaryData
     */
    public function setWindlevel($windlevel)
    {
        $this->windlevel = $windlevel;

        return $this;
    }

    /**
     * Get windlevel
     *
     * @return integer
     */
    public function getWindlevel()
    {
        return $this->windlevel;
    }

    /**
     * Set rainlevel
     *
     * @param integer $rainlevel
     *
     * @return TemporaryData
     */
    public function setRainlevel($rainlevel)
    {
        $this->rainlevel = $rainlevel;

        return $this;
    }

    /**
     * Get rainlevel
     *
     * @return integer
     */
    public function getRainlevel()
    {
        return $this->rainlevel;
    }

    /**
     * Set pressure
     *
     * @param integer $pressure
     *
     * @return TemporaryData
     */
    public function setPressure($pressure)
    {
        $this->pressure = $pressure;

        return $this;
    }

    /**
     * Get pressure
     *
     * @return integer
     */
    public function getPressure()
    {
        return $this->pressure;
    }

    /**
     * Set liquidwaste
     *
     * @param integer $liquidwaste
     *
     * @return TemporaryData
     */
    public function setLiquidwaste($liquidwaste)
    {
        $this->liquidwaste = $liquidwaste;

        return $this;
    }

    /**
     * Get liquidwaste
     *
     * @return integer
     */
    public function getLiquidwaste()
    {
        return $this->liquidwaste;
    }

    /**
     * Set hometemperature
     *
     * @param float $hometemperature
     *
     * @return TemporaryData
     */
    public function setHometemperature($hometemperature)
    {
        $this->hometemperature = $hometemperature;

        return $this;
    }

    /**
     * Get hometemperature
     *
     * @return float
     */
    public function getHometemperature()
    {
        return $this->hometemperature;
    }

    /**
     * Set homehumidity
     *
     * @param integer $homehumidity
     *
     * @return TemporaryData
     */
    public function setHomehumidity($homehumidity)
    {
        $this->homehumidity = $homehumidity;

        return $this;
    }

    /**
     * Get homehumidity
     *
     * @return integer
     */
    public function getHomehumidity()
    {
        return $this->homehumidity;
    }

    /**
     * Set blindlevel
     *
     * @param integer $blindlevel
     *
     * @return TemporaryData
     */
    public function setBlindlevel($blindlevel)
    {
        $this->blindlevel = $blindlevel;

        return $this;
    }

    /**
     * Get blindlevel
     *
     * @return integer
     */
    public function getBlindlevel()
    {
        return $this->blindlevel;
    }

    /**
     * Set heatinglevel
     *
     * @param integer $heatinglevel
     *
     * @return TemporaryData
     */
    public function setHeatinglevel($heatinglevel)
    {
        $this->heatinglevel = $heatinglevel;

        return $this;
    }

    /**
     * Get heatinglevel
     *
     * @return integer
     */
    public function getHeatinglevel()
    {
        return $this->heatinglevel;
    }

    /**
     * Set wateringstate
     *
     * @param boolean $wateringstate
     *
     * @return TemporaryData
     */
    public function setWateringstate($wateringstate)
    {
        $this->wateringstate = $wateringstate;

        return $this;
    }

    /**
     * Get wateringstate
     *
     * @return boolean
     */
    public function getWateringstate()
    {
        return $this->wateringstate;
    }
}
