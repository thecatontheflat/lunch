<?php

namespace LunchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        $participants = $this->getDoctrine()
            ->getRepository('LunchBundle:Participant')
            ->findAll();

        return $this->render('LunchBundle:Dashboard:index.html.twig', [
            'participantsAmount' => count($participants)
        ]);
    }
}
