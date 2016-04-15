<?php

namespace AccueilBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ReservationRepository extends EntityRepository
{
    public function countToday($date)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->select('count(t.id)');
        $qb->where('t.dateResa = :dateDebut');
        $qb->setParameter('dateDebut', $date);

        return $qb->getQuery()->getSingleScalarResult();
    }
}
