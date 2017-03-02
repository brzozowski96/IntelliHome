<?php

namespace Brzozowski\IntelliHomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HeatingTimetable
 *
 * @ORM\Table(name="heating_timetable")
 * @ORM\Entity
 */
class HeatingTimetable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="DayOfWeek", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $dayOfWeek;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="StartBlock1", type="time", nullable=false)
     */
    private $startBlock1;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="StopBlock1", type="time", nullable=false)
     */
    private $stopBlock1;

    /**
     * @var integer
     *
     * @ORM\Column(name="ModeBlock1", type="integer", nullable=false)
     */
    private $modeBlock1;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="StartBlock2", type="time", nullable=true)
     */
    private $startBlock2;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="StopBlock2", type="time", nullable=true)
     */
    private $stopBlock2;

    /**
     * @var integer
     *
     * @ORM\Column(name="ModeBlock2", type="integer", nullable=true)
     */
    private $modeBlock2;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="StartBlock3", type="time", nullable=true)
     */
    private $startBlock3;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="StopBlock3", type="time", nullable=true)
     */
    private $stopBlock3;

    /**
     * @var integer
     *
     * @ORM\Column(name="ModeBlock3", type="integer", nullable=true)
     */
    private $modeBlock3;



    /**
     * Get dayOfWeek
     *
     * @return integer
     */
    public function getDayOfWeek()
    {
        return $this->dayOfWeek;
    }

    /**
     * Set startBlock1
     *
     * @param \DateTime $startBlock1
     *
     * @return HeatingTimetable
     */
    public function setStartBlock1($startBlock1)
    {
        $this->startBlock1 = $startBlock1;

        return $this;
    }

    /**
     * Get startBlock1
     *
     * @return \DateTime
     */
    public function getStartBlock1()
    {
        return $this->startBlock1;
    }

    /**
     * Set stopBlock1
     *
     * @param \DateTime $stopBlock1
     *
     * @return HeatingTimetable
     */
    public function setStopBlock1($stopBlock1)
    {
        $this->stopBlock1 = $stopBlock1;

        return $this;
    }

    /**
     * Get stopBlock1
     *
     * @return \DateTime
     */
    public function getStopBlock1()
    {
        return $this->stopBlock1;
    }

    /**
     * Set modeBlock1
     *
     * @param integer $modeBlock1
     *
     * @return HeatingTimetable
     */
    public function setModeBlock1($modeBlock1)
    {
        $this->modeBlock1 = $modeBlock1;

        return $this;
    }

    /**
     * Get modeBlock1
     *
     * @return integer
     */
    public function getModeBlock1()
    {
        return $this->modeBlock1;
    }

    /**
     * Set startBlock2
     *
     * @param \DateTime $startBlock2
     *
     * @return HeatingTimetable
     */
    public function setStartBlock2($startBlock2)
    {
        $this->startBlock2 = $startBlock2;

        return $this;
    }

    /**
     * Get startBlock2
     *
     * @return \DateTime
     */
    public function getStartBlock2()
    {
        return $this->startBlock2;
    }

    /**
     * Set stopBlock2
     *
     * @param \DateTime $stopBlock2
     *
     * @return HeatingTimetable
     */
    public function setStopBlock2($stopBlock2)
    {
        $this->stopBlock2 = $stopBlock2;

        return $this;
    }

    /**
     * Get stopBlock2
     *
     * @return \DateTime
     */
    public function getStopBlock2()
    {
        return $this->stopBlock2;
    }

    /**
     * Set modeBlock2
     *
     * @param integer $modeBlock2
     *
     * @return HeatingTimetable
     */
    public function setModeBlock2($modeBlock2)
    {
        $this->modeBlock2 = $modeBlock2;

        return $this;
    }

    /**
     * Get modeBlock2
     *
     * @return integer
     */
    public function getModeBlock2()
    {
        return $this->modeBlock2;
    }

    /**
     * Set startBlock3
     *
     * @param \DateTime $startBlock3
     *
     * @return HeatingTimetable
     */
    public function setStartBlock3($startBlock3)
    {
        $this->startBlock3 = $startBlock3;

        return $this;
    }

    /**
     * Get startBlock3
     *
     * @return \DateTime
     */
    public function getStartBlock3()
    {
        return $this->startBlock3;
    }

    /**
     * Set stopBlock3
     *
     * @param \DateTime $stopBlock3
     *
     * @return HeatingTimetable
     */
    public function setStopBlock3($stopBlock3)
    {
        $this->stopBlock3 = $stopBlock3;

        return $this;
    }

    /**
     * Get stopBlock3
     *
     * @return \DateTime
     */
    public function getStopBlock3()
    {
        return $this->stopBlock3;
    }

    /**
     * Set modeBlock3
     *
     * @param integer $modeBlock3
     *
     * @return HeatingTimetable
     */
    public function setModeBlock3($modeBlock3)
    {
        $this->modeBlock3 = $modeBlock3;

        return $this;
    }

    /**
     * Get modeBlock3
     *
     * @return integer
     */
    public function getModeBlock3()
    {
        return $this->modeBlock3;
    }

    public function getStopBlock($blockNumber)
    {
        switch ($blockNumber)
        {
            case 1: {
                return $this->getStopBlock1();
                break;
            }
            case 2: {
                return $this->getStopBlock2();
                break;
            }
            case 3: {
                return $this->getStopBlock3();
                break;
            }
        }
    }

    public function getStartBlock($blockNumber)
    {
        switch ($blockNumber)
        {
            case 1: {
                return $this->getStartBlock1();
                break;
            }
            case 2: {
                return $this->getStartBlock2();
                break;
            }
            case 3: {
                return $this->getStartBlock3();
                break;
            }
        }
    }

    public function getModeBlock($blockNumber)
    {
        switch ($blockNumber)
        {
            case 1: {
                return $this->getModeBlock1();
                break;
            }
            case 2: {
                return $this->getModeBlock2();
                break;
            }
            case 3: {
                return $this->getModeBlock3();
                break;
            }
        }
    }
}
