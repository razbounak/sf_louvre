<?php

namespace AccueilBundle\AttributionTarifs;

use AccueilBundle\Entity\Billet;
use AccueilBundle\Entity\Reservation;
use Doctrine\ORM\EntityManager;

class AccueilAttributionTarifs
{
    private $em = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function attributionTarifs(Billet $billet)
    {
        $datetime = new \DateTime();

        $dateBebe = clone $billet->getDateNaissance();
        $dateSenior = clone $billet->getDateNaissance();
        $dateEnfant = clone $billet->getDateNaissance();

        $dateBebe->add(new \DateInterval('P4Y'));
        $dateSenior->add(new \DateInterval('P60Y'));
        $dateEnfant->add(new \DateInterval('P12Y'));

        if ($dateBebe > $datetime)
            $slug = 'bebe';
        elseif ($dateBebe < $datetime && $dateEnfant > $datetime)
            $slug = 'enfant';
        elseif ($billet->getTarifReduit() === true)
            $slug = 'reduit';
        elseif ($dateSenior < $datetime)
            $slug = 'senior';
        else
            $slug = 'normal';

        $billet->setTarifs($this->em->getRepository('AccueilBundle:Tarifs')->findOneBySlug($slug));
    }

    public function attributionFamille(Reservation $reservation)
    {
        //$this->em->getRepository('AccueilBundle:Billet')->findBy()
        /*
         * Compter le nombre d'enfant et de parent
         * Enfant / 2
         * Parent / 2
         * if(enfant >= 1 && parent >= 1)
         * {
         *     On prend le plus petit nombre des deux
         *     while(pluspetitnombre != 0)
         *     {
         *         On met 2 enfant en famille
         *         On met 2 parent en famille
         *         pluspetitnombre--;
         *     }
         * }
         */
    }
}
