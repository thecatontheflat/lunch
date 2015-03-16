<?php

namespace LunchBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ParticipantRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ParticipantRepository extends EntityRepository
{
    /**
     * @return Participant[]
     */
    public function findAllOrdered()
    {
        $query = $this->createQueryBuilder('p')
            ->addOrderBy('p.department', 'ASC')
            ->addOrderBy('p.email', 'ASC')
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @return Participant[]
     */
    public function findAttending()
    {
        $query = $this->createQueryBuilder('p')
            ->where('p.isAttending = :attending')
            ->setParameter('attending', true)
            ->getQuery();

        return $query->getResult();
    }
}
