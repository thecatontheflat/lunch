<?php

namespace LunchBundle\Command;

use Hip\MandrillBundle\Message;
use LunchBundle\Entity\Participant;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendConfirmationEmailCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('lunch:email:send')
            ->setDescription('Sends confirmation emails')
            ->addArgument('id')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dispatcher = $this->getContainer()->get('hip_mandrill.dispatcher');
        $participant = $this->getContainer()->get('doctrine')
            ->getRepository('LunchBundle:Participant')
            ->find($input->getArgument('id'));

        $router = $this->getContainer()->get('router');
        $path = $router->generate('participant_confirm', ['id' => $participant->getId()]);
        $url = $this->getContainer()->getParameter('domain').$path;

        $html = $this->getContainer()->get('templating')->render(
            'LunchBundle:Email:invitation.html.twig', [
                'acceptLink' => $url
            ]
        );

        $message = new Message();
        $message
            ->setSubject('Blind Lunch')
            ->setHtml($html);
        $message->addTo($participant->getEmail());

        $dispatcher->send($message, '', [], true);
    }

}