<?php

namespace Brzozowski\IntelliHomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MotionSensors
 *
 * @ORM\Table(name="motion_sensors")
 * @ORM\Entity
 */
class MotionSensors
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="Id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="RoomName", type="string", length=20, nullable=false)
     */
    private $roomName;



    /**
     * Get id
     *
     * @return boolean
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set roomName
     *
     * @param string $roomName
     *
     * @return MotionSensors
     */
    public function setRoomName($roomName)
    {
        $this->roomName = $roomName;

        return $this;
    }

    /**
     * Get roomName
     *
     * @return string
     */
    public function getRoomName()
    {
        return $this->roomName;
    }
}
