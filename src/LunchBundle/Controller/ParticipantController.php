<?php

namespace LunchBundle\Controller;

use LunchBundle\Entity\Participant;
use LunchBundle\Form\ParticipantType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ParticipantController extends Controller
{
    public function createAction(Request $request)
    {
        $form = $this->createForm(new ParticipantType());
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $participant = $form->getData();
            $this->getDoctrine()->getManager()->persist($participant);
            $this->getDoctrine()->getManager()->flush();

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
            $this->getDoctrine()->getManager()->remove($participant);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
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

    public function editAction(Request $request, Participant $participant)
    {
        $form = $this->createForm(new ParticipantType(), $participant);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $this->getDoctrine()->getManager()->persist($participant);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', sprintf('Participant %s was updated!', $participant->getEmail()));

            return $this->redirectToRoute('participant_list');
        }

        return $this->render(
            'LunchBundle:Participant:edit.html.twig', [
                'participant' => $participant,
                'form' => $form->createView()
            ]
        );
    }

    public function listAction(Request $request)
    {
        $participants = $this->getDoctrine()
            ->getRepository('LunchBundle:Participant')
            ->findAllOrdered();

        $form = $this->createForm(new ParticipantType());


        return $this->render(
            'LunchBundle:Participant:list.html.twig', [
                'participants' => $participants,
                'form' => $form->createView()
            ]
        );
    }
    
    public function confirmParticipationAction(Request $request, $id)
    {
        $participant = $this->getDoctrine()
            ->getRepository('LunchBundle:Participant')
            ->find($id);
        
        $participant->setIsAttending(true);
        $this->getDoctrine()->getManager()->persist($participant);
        $this->getDoctrine()->getManager()->flush();

        return $this->render('LunchBundle:Email:thankyou.html.twig');
    }

}
