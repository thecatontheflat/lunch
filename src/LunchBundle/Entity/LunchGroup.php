<?php

namespace LunchBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\OneToMany(targetEntity="Participant", mappedBy="lunchGroup")
     */
    protected $participants;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

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
     * Add participants
     *
     * @param \LunchBundle\Entity\Participant $participant
     * @return LunchGroup
     */
    public function addParticipant(Participant $participant)
    {
        $participant->setLunchGroup($this);

        $this->participants[] = $participant;

        return $this;
    }

    /**
     * Remove participants
     *
     * @param \LunchBundle\Entity\Participant $participants
     */
    public function removeParticipant(Participant $participants)
    {
        $this->participants->removeElement($participants);
    }

    /**
     * Get participants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParticipants()
    {
        return $this->participants;
    }
}
