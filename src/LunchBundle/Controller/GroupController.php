<?php

namespace LunchBundle\Controller;

use LunchBundle\Entity\LunchGroup;
use LunchBundle\Generator\GroupGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GroupController extends Controller
{
    public function generateAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $groups = $this->getDoctrine()
            ->getRepository('LunchBundle:LunchGroup')
            ->findAll();

        foreach ($groups as $group) {
            $em->remove($group);
        }
        $em->flush();


        $participants = $this->getDoctrine()
            ->getRepository('LunchBundle:Participant')
            ->findAll();

        shuffle($participants);
        $shuffler = new GroupGenerator($participants, 4);
        $distributedGroups = $shuffler->generateGroups();


        foreach ($distributedGroups as $group) {
            $lunchGroup = new LunchGroup();
            foreach ($group as $participant) {
                $participant->setLunchGroup($lunchGroup);
                $em->persist($lunchGroup);
                $em->persist($participant);
                $em->flush();
            }
        }
        $em->flush();


        return $this->redirectToRoute('group_list');
    }

    public function listAction()
    {
        $groups = $this->getDoctrine()
            ->getRepository('LunchBundle:LunchGroup')
            ->findAll();

        return $this->render('LunchBundle:Group:list.html.twig', [
            'groups' => $groups
        ]);
    }
}
