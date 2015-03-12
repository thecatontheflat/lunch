<?php

namespace LunchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GroupController extends Controller
{
    public function listAction()
    {
        $participants = $this->getDoctrine()
            ->getRepository('LunchBundle:Participant')
            ->findAll();

        shuffle($participants);

        $groups = array_chunk($participants, 4);

        $lastGroup = end($groups);
        if (count($lastGroup) < 3) {
            $lastGroup = array_pop($groups);
            $i = 0;
            while ($lastGroup) {
                array_push($groups[$i], array_pop($lastGroup));
                $i++;
            }
        }

        return $this->render('LunchBundle:Group:list.html.twig', [
            'groups' => $groups
        ]);
    }
}
