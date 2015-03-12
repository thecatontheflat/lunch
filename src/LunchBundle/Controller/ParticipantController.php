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
                sprintf('Participant %s was added!', $participant->getEmail())
            );
        }

        return $this->redirectToRoute('participant_list');
    }

    public function deleteAction(Request $request, Participant $participant)
    {
        if ($request->isMethod('POST')) {
            $this->getDoctrine()->getEntityManager()->remove($participant);
            $this->getDoctrine()->getEntityManager()->flush();

            $request->getSession()->getFlashBag()->add(
                'success',
                sprintf('Participant %s was removed!', $participant->getEmail())
            );

            return $this->redirectToRoute('participant_list');
        }

        return $this->render(
            'LunchBundle:Participant:delete.html.twig',
            ['participant' => $participant]
        );
    }

    public function listAction(Request $request)
    {
        $participants = $this->getDoctrine()
            ->getRepository('LunchBundle:Participant')
            ->findAll();


        return $this->render(
            'LunchBundle:Participant:list.html.twig',
            ['participants' => $participants]
        );
    }

}
