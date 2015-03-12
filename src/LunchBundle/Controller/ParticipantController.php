<?php

namespace LunchBundle\Controller;

use LunchBundle\Entity\Participant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ParticipantController extends Controller
{
    public function createAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $participant = new Participant();
            $participant->setEmail($request->get('email'));

            $this->getDoctrine()->getEntityManager()->persist($participant);
            $this->getDoctrine()->getEntityManager()->flush();

            $request->getSession()->getFlashBag()->add(
                'success',
                'Participant was added!'
            );
        }

        return $this->redirectToRoute('participant_list');
    }

    public function deleteAction()
    {
        return $this->render(
            'LunchBundle:Participant:delete.html.twig',
            []
        );
    }

    public function listAction(Request $request)
    {
        return $this->render(
            'LunchBundle:Participant:list.html.twig',
            []
        );
    }

}
