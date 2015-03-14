<?php

namespace LunchBundle\Generator;

use LunchBundle\Entity\Participant;

class GroupGenerator
{
    /** @var Participant[] */
    private $participants;

    private $groupSize;

    private $totalParticipants = 0;
    private $totalGroups = 0;

    public function __construct($participants, $groupSize)
    {
        shuffle($participants);

        $this->participants = $participants;
        $this->groupSize = $groupSize;

        $this->totalParticipants = count($this->participants);
        $this->totalGroups = floor($this->totalParticipants / $this->groupSize);
    }

    public function generateGroups()
    {
        $groupsByDepartment = $this->groupByDepartment($this->participants);
        $this->orderGroupByDepartmentSize($groupsByDepartment);
        $distributedGroup = $this->distributeParticipants($groupsByDepartment);

        return $distributedGroup;
    }

    private function distributeParticipants($groups)
    {
        $groupCounter = 0;
        $distributedGroups = [];
        foreach ($groups as $department) {
            while (!empty($department)) {
                $groupCounter = $groupCounter == $this->totalGroups ? 0 : $groupCounter;
                if (!isset($distributedGroups[$groupCounter])) {
                    $distributedGroups[$groupCounter] = [];
                }

                array_push($distributedGroups[$groupCounter], array_pop($department));
                $groupCounter++;
            }
        }

        return $distributedGroups;
    }

    private function orderGroupByDepartmentSize(&$groups)
    {
        uasort(
            $groups,
            function ($a, $b) {
                return count($b) - count($a);
            }
        );
    }

    /**
     * @param Participant[] $participants
     * @return array
     */
    private function groupByDepartment($participants)
    {
        $groupsByDepartment = [];
        foreach ($participants as $participant) {
            if (!isset($groupsByDepartment[$participant->getDepartment()])) {
                $groupsByDepartment[$participant->getDepartment()] = [];
            }
            array_push($groupsByDepartment[$participant->getDepartment()], $participant);
        }

        return $groupsByDepartment;
    }
}