<?php

namespace LunchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Hip\MandrillBundle\Message;
use Hip\MandrillBundle\Dispatcher;

class DashboardController extends Controller
{
    public function indexAction()
    {
        $participants = $this->getDoctrine()
            ->getRepository('LunchBundle:Participant')
            ->findAll();

        $attendingParticipants = $this->getDoctrine()
            ->getRepository('LunchBundle:Participant')
            ->findAttending();

        return $this->render(
            'LunchBundle:Dashboard:index.html.twig', [
                'participantsAmount' => count($participants),
                'attendingParticipants' => count($attendingParticipants)
            ]
        );
    }

    public function sendInvitesAction(Request $request)
    {
        $this->getDoctrine()
            ->getRepository('LunchBundle:Participant')
            ->resetIsAttending();

        $participants = $this->getDoctrine()
            ->getRepository('LunchBundle:Participant')
            ->findAll();

        $rootPath = $this->get('kernel')->getRootDir();
        foreach ($participants as $participant) {
            $cmd = $rootPath.'/console lunch:email:send '.$participant->getId().' > /dev/null &';

            exec($cmd);
        }

        $this->addFlash('success', 'Invitation emails were sent!');

        return $this->redirectToRoute('dashboard');
    }
}
