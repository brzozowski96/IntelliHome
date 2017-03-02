<?php

namespace Brzozowski\IntelliHomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServicesDeadlines
 *
 * @ORM\Table(name="services_deadlines")
 * @ORM\Entity
 */
class ServicesDeadlines
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
     * @ORM\Column(name="ServiceName", type="string", length=30, nullable=false)
     */
    private $servicename;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DeadlineDate", type="date", nullable=false)
     */
    private $deadlinedate;


}

