<?php

namespace Brzozowski\IntelliHomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WeatherStation
 *
 * @ORM\Table(name="weather_station")
 * @ORM\Entity(repositoryClass="WeatherStationRepository")
 */
class WeatherStation
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
     * @ORM\Column(name="City", type="text", length=65535, nullable=false)
     */
    private $city;

    /**
     * @var float
     *
     * @ORM\Column(name="Temperature", type="float", precision=10, scale=0, nullable=false)
     */
    private $temperature;

    /**
     * @var float
     *
     * @ORM\Column(name="FeelsLike", type="float", precision=10, scale=0, nullable=false)
     */
    private $feelslike;

    /**
     * @var integer
     *
     * @ORM\Column(name="Humidity", type="integer", nullable=false)
     */
    private $humidity;

    /**
     * @var string
     *
     * @ORM\Column(name="SolarRadiation", type="text", length=65535, nullable=false)
     */
    private $solarradiation;

    /**
     * @var string
     *
     * @ORM\Column(name="UV", type="text", length=65535, nullable=false)
     */
    private $uv;

    /**
     * @var float
     *
     * @ORM\Column(name="WindLevel", type="float", precision=10, scale=0, nullable=false)
     */
    private $windlevel;

    /**
     * @var float
     *
     * @ORM\Column(name="RainLevel", type="float", precision=10, scale=0, nullable=false)
     */
    private $rainlevel;

    /**
     * @var float
     *
     * @ORM\Column(name="RainToday", type="float", precision=10, scale=0, nullable=false)
     */
    private $raintoday;

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
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city)
    {
        $this->city = $city;
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
    public function getFeelslike(): float
    {
        return $this->feelslike;
    }

    /**
     * @param float $feelslike
     */
    public function setFeelslike(float $feelslike)
    {
        $this->feelslike = $feelslike;
    }

    /**
     * @return int
     */
    public function getHumidity(): int
    {
        return $this->humidity;
    }

    /**
     * @param int $humidity
     */
    public function setHumidity(int $humidity)
    {
        $this->humidity = $humidity;
    }

    /**
     * @return string
     */
    public function getSolarradiation(): string
    {
        return $this->solarradiation;
    }

    /**
     * @param string $solarradiation
     */
    public function setSolarradiation(string $solarradiation)
    {
        $this->solarradiation = $solarradiation;
    }

    /**
     * @return string
     */
    public function getUv(): string
    {
        return $this->uv;
    }

    /**
     * @param string $uv
     */
    public function setUv(string $uv)
    {
        $this->uv = $uv;
    }

    /**
     * @return float
     */
    public function getWindlevel(): float
    {
        return $this->windlevel;
    }

    /**
     * @param float $windlevel
     */
    public function setWindlevel(float $windlevel)
    {
        $this->windlevel = $windlevel;
    }

    /**
     * @return float
     */
    public function getRainlevel(): float
    {
        return $this->rainlevel;
    }

    /**
     * @param float $rainlevel
     */
    public function setRainlevel(float $rainlevel)
    {
        $this->rainlevel = $rainlevel;
    }

    /**
     * @return int
     */
    public function getPressure(): int
    {
        return $this->pressure;
    }

    /**
     * @param int $pressure
     */
    public function setPressure(int $pressure)
    {
        $this->pressure = $pressure;
    }

    /**
     * @return float
     */
    public function getRaintoday(): float
    {
        return $this->raintoday;
    }

    /**
     * @param float $raintoday
     */
    public function setRaintoday(float $raintoday)
    {
        $this->raintoday = $raintoday;
    }

    /**
     * @return int
     */
    public function getLiquidwaste(): int
    {
        return $this->liquidwaste;
    }

    /**
     * @param int $liquidwaste
     */
    public function setLiquidwaste(int $liquidwaste)
    {
        $this->liquidwaste = $liquidwaste;
    }


}

