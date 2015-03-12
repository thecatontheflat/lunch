<?php

namespace LunchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function createAction()
    {
        return $this->render(
            'LunchBundle:User:create.html.twig',
            []
        );
    }

    public function deleteAction()
    {
        return $this->render(
            'LunchBundle:User:delete.html.twig',
            []
        );
    }

    public function listAction()
    {
        return $this->render(
            'LunchBundle:User:list.html.twig',
            []
        );
    }

}
