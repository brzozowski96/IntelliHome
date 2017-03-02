<?php

namespace Brzozowski\IntelliHomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings
 *
 * @ORM\Table(name="settings")
 * @ORM\Entity
 */
class Settings
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
     * @var string
     *
     * @ORM\Column(name="AlarmPhoneNumber", type="string", length=15, nullable=false)
     */
    private $alarmPhoneNumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="BlindTime", type="integer", nullable=false)
     */
    private $blindTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="SirenTime", type="integer", nullable=false)
     */
    private $sirenTime;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ShowCameraViewWhenAlarmDeactivated", type="boolean", nullable=false)
     */
    private $showCameraViewWhenAlarmDeactivated;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ChangeBlindsAfterAlarmActicated", type="boolean", nullable=false)
     */
    private $changeBlindsAfterAlarmActicated;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ChangeHeatingAfterAlarmActicated", type="boolean", nullable=false)
     */
    private $changeHeatingAfterAlarmActicated;

    /**
     * @var boolean
     *
     * @ORM\Column(name="PreventHeating", type="boolean", nullable=false)
     */
    private $preventHeating;

    /**
     * @var boolean
     *
     * @ORM\Column(name="PreventBlindsDamage", type="boolean", nullable=false)
     */
    private $preventBlindsDamage;


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
     * Set alarmPhoneNumber
     *
     * @param string $alarmPhoneNumber
     *
     * @return Settings
     */
    public function setAlarmPhoneNumber($alarmPhoneNumber)
    {
        $this->alarmPhoneNumber = $alarmPhoneNumber;

        return $this;
    }

    /**
     * Get alarmPhoneNumber
     *
     * @return string
     */
    public function getAlarmPhoneNumber()
    {
        return $this->alarmPhoneNumber;
    }

    /**
     * Set blindTime
     *
     * @param integer $blindTime
     *
     * @return Settings
     */
    public function setBlindTime($blindTime)
    {
        $this->blindTime = $blindTime;

        return $this;
    }

    /**
     * Get blindTime
     *
     * @return integer
     */
    public function getBlindTime()
    {
        return $this->blindTime;
    }

    /**
     * Set sirenTime
     *
     * @param integer $sirenTime
     *
     * @return Settings
     */
    public function setSirenTime($sirenTime)
    {
        $this->sirenTime = $sirenTime;

        return $this;
    }

    /**
     * Get sirenTime
     *
     * @return integer
     */
    public function getSirenTime()
    {
        return $this->sirenTime;
    }

    /**
     * Set showCameraViewWhenAlarmDeactivated
     *
     * @param boolean $showCameraViewWhenAlarmDeactivated
     *
     * @return Settings
     */
    public function setShowCameraViewWhenAlarmDeactivated($showCameraViewWhenAlarmDeactivated)
    {
        $this->showCameraViewWhenAlarmDeactivated = $showCameraViewWhenAlarmDeactivated;

        return $this;
    }

    /**
     * Get showCameraViewWhenAlarmDeactivated
     *
     * @return boolean
     */
    public function getShowCameraViewWhenAlarmDeactivated()
    {
        return $this->showCameraViewWhenAlarmDeactivated;
    }

    /**
     * Set changeBlindsAfterAlarmActicated
     *
     * @param boolean $changeBlindsAfterAlarmActicated
     *
     * @return Settings
     */
    public function setChangeBlindsAfterAlarmActicated($changeBlindsAfterAlarmActicated)
    {
        $this->changeBlindsAfterAlarmActicated = $changeBlindsAfterAlarmActicated;

        return $this;
    }

    /**
     * Get changeBlindsAfterAlarmActicated
     *
     * @return boolean
     */
    public function getChangeBlindsAfterAlarmActicated()
    {
        return $this->changeBlindsAfterAlarmActicated;
    }

    /**
     * Set changeHeatingAfterAlarmActicated
     *
     * @param boolean $changeHeatingAfterAlarmActicated
     *
     * @return Settings
     */
    public function setChangeHeatingAfterAlarmActicated($changeHeatingAfterAlarmActicated)
    {
        $this->changeHeatingAfterAlarmActicated = $changeHeatingAfterAlarmActicated;

        return $this;
    }

    /**
     * Get changeHeatingAfterAlarmActicated
     *
     * @return boolean
     */
    public function getChangeHeatingAfterAlarmActicated()
    {
        return $this->changeHeatingAfterAlarmActicated;
    }

    /**
     * Set preventHeating
     *
     * @param boolean $preventHeating
     *
     * @return Settings
     */
    public function setPreventHeating($preventHeating)
    {
        $this->preventHeating = $preventHeating;

        return $this;
    }

    /**
     * Get preventHeating
     *
     * @return boolean
     */
    public function getPreventHeating()
    {
        return $this->preventHeating;
    }

    /**
     * Set preventBlindsDamage
     *
     * @param boolean $preventBlindsDamage
     *
     * @return Settings
     */
    public function setPreventBlindsDamage($preventBlindsDamage)
    {
        $this->preventBlindsDamage = $preventBlindsDamage;

        return $this;
    }

    /**
     * Get preventBlindsDamage
     *
     * @return boolean
     */
    public function getPreventBlindsDamage()
    {
        return $this->preventBlindsDamage;
    }
}
