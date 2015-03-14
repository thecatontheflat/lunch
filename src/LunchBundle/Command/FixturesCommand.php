<?php

namespace LunchBundle\Command;

use LunchBundle\Entity\Participant;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixturesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fixtures:load')
            ->setDescription('Load fixtures');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $query = $em->createQuery('DELETE FROM \LunchBundle\Entity\Participant');
        $query->execute();

        $departments = ['IT', 'OPS', 'SALES', 'HR', 'MARKETING'];
        for ($i = 0; $i < 25; $i++) {
            $participant = $this->generateParticipant($i, $departments[array_rand($departments)]);
            $em->persist($participant);
        }
        $em->flush();


        $output->writeln('Fixtures loaded');
    }

    private function generateParticipant($id, $department)
    {
        $participant = new Participant();
        $participant->setEmail('some'.$id.'@gmail.com');
        $participant->setDepartment($department);

        return $participant;
    }
}