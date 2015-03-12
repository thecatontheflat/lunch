<?php

namespace LunchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participant
 *
 * @ORM\Table(name="participant")
 * @ORM\Entity(repositoryClass="LunchBundle\Entity\ParticipantRepository")
 */
class Participant
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
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="LunchGroup", inversedBy="participants")
     * @ORM\JoinColumn(name="lunch_group_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $lunchGroup;


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
     * Set email
     *
     * @param string $email
     * @return Participant
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set lunchGroup
     *
     * @param LunchGroup $lunchGroup
     * @return Participant
     */
    public function setLunchGroup(LunchGroup $lunchGroup = null)
    {
        $this->lunchGroup = $lunchGroup;

        return $this;
    }

    /**
     * Get lunchGroup
     *
     * @return LunchGroup
     */
    public function getLunchGroup()
    {
        return $this->lunchGroup;
    }
}
