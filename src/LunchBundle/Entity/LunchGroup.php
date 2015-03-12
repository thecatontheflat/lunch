<?php

namespace LunchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LunchGroup
 *
 * @ORM\Table(name="lunch_group")
 * @ORM\Entity(repositoryClass="LunchBundle\Entity\LunchGroupRepository")
 */
class LunchGroup
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
