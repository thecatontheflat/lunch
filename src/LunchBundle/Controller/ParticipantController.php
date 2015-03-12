<?php

namespace LunchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ParticipantController extends Controller
{
    public function createAction()
    {
        return $this->render(
            'LunchBundle:Participant:create.html.twig',
            []
        );
    }

    public function deleteAction()
    {
        return $this->render(
            'LunchBundle:Participant:delete.html.twig',
            []
        );
    }

    public function listAction()
    {
        return $this->render(
            'LunchBundle:Participant:list.html.twig',
            []
        );
    }

}
