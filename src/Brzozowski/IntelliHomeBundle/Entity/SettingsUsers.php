<?php

namespace Brzozowski\IntelliHomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings
 *
 * @ORM\Table(name="settings_users")
 * @ORM\Entity
 */
class SettingsUsers
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
     * @var integer
     *
     * @ORM\Column(name="UserId", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="LiquidWasteEmail", type="boolean", nullable=false)
     */
    private $liquidWasteEmail;

    /**
     * @var boolean
     *
     * @ORM\Column(name="LogsEmail", type="boolean", nullable=false)
     */
    private $logsEmail;



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
     * Set liquidWasteEmail
     *
     * @param boolean $liquidWasteEmail
     *
     * @return SettingsUsers
     */
    public function setLiquidWasteEmail($liquidWasteEmail)
    {
        $this->liquidWasteEmail = $liquidWasteEmail;

        return $this;
    }

    /**
     * Get liquidWasteEmail
     *
     * @return boolean
     */
    public function getLiquidWasteEmail()
    {
        return $this->liquidWasteEmail;
    }

    /**
     * Set logsEmail
     *
     * @param boolean $logsEmail
     *
     * @return SettingsUsers
     */
    public function setLogsEmail($logsEmail)
    {
        $this->logsEmail = $logsEmail;

        return $this;
    }

    /**
     * Get logsEmail
     *
     * @return boolean
     */
    public function getLogsEmail()
    {
        return $this->logsEmail;
    }
}
