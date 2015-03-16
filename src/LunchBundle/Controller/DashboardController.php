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
        $dispatcher = $this->get('hip_mandrill.dispatcher');
        $participants = $this->getDoctrine()
            ->getRepository('LunchBundle:Participant')
            ->findAttending();

        $result = null;
        if ($participants) {
            $message = new Message();
            $message
                ->setSubject('Blind Lunch')
                ->setHtml('<html><body><h1>Some Content</h1></body></html>');

            foreach ($participants as $participant) {
                $message->addTo($participant->getEmail());
            }

            $dispatcher->send($message);

            $this->addFlash('success', 'Invitation emails were sent!');
        }

        return $this->redirectToRoute('dashboard');
    }
}
