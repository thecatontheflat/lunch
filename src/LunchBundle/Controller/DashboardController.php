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

        $dispatcher = $this->get('hip_mandrill.dispatcher');
        $participants = $this->getDoctrine()
            ->getRepository('LunchBundle:Participant')
            ->findAll();

        $result = null;
        if ($participants) {
            $html = $this->renderView('LunchBundle:Email:invitation.html.twig', [
                'acceptLink' => '#'
            ]);

            foreach ($participants as $participant) {
                $message = new Message();
                $message
                    ->setSubject('Blind Lunch')
                    ->setHtml($html);
                $message->addTo($participant->getEmail());
                $dispatcher->send($message, '', [], true);
            }

            $this->addFlash('success', 'Invitation emails were sent!');
        }

        return $this->redirectToRoute('dashboard');
    }
}
