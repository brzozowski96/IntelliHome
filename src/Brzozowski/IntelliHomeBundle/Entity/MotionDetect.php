<?php

namespace Brzozowski\IntelliHomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MotionDetect
 *
 * @ORM\Table(name="motion_detect")
 * @ORM\Entity
 */
class MotionDetect
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
     * @var boolean
     *
     * @ORM\Column(name="PIRId", type="boolean", nullable=false)
     */
    private $pirid;


}

