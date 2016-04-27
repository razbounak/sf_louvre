<?php

namespace AccueilBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BilletRepository extends EntityRepository
{
    public function getReservationDay($date)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->select('count(t.id)');
        $qb->leftJoin('t.reservation', 'resa');
        $qb->where('resa.dateResa = :dateDebut');
        $qb->setParameter('dateDebut', $date);

        $nb_billets = $qb->getQuery()->getSingleScalarResult();

        return $nb_billets;
    }
}
  