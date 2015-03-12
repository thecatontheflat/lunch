<?php

namespace LunchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GroupController extends Controller
{
    public function listAction()
    {
        return $this->render('LunchBundle:Group:list.html.twig', []);
    }
}
