<?php

namespace AccueilBundle\AttributionTarifs;

use Doctrine\ORM\EntityManager;

class AccueilAttributionTarifs
{
    private $em = null;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function attributionTarifs($billet)
    {
        
        $datetime = new \DateTime();
        
        $dateBebe = clone $billet->getDateNaissance();
        $dateSenior = clone $billet->getDateNaissance();
        $dateEnfant = clone $billet->getDateNaissance();
        $dateBebe->add(new \DateInterval('P4Y'));
        $dateSenior->add(new \DateInterval('P60Y'));
        $dateEnfant->add(new \DateInterval('P12Y'));
        if($dateBebe > $datetime)
            $billet->setTarifs($em->getRepository('AccueilBundle:Tarifs')->find(6));
        elseif($dateBebe < $datetime && $dateEnfant > $datetime)
            $billet->setTarifs($em->getRepository('AccueilBundle:Tarifs')->find(2));
        elseif($billet->getTarifReduit() === true)
            $billet->setTarifs($em->getRepository('AccueilBundle:Tarifs')->find(4));
        elseif($dateSenior < $datetime)
            $billet->setTarifs($em->getRepository('AccueilBundle:Tarifs')->find(3));
        else
            $billet->setTarifs($em->getRepository('AccueilBundle:Tarifs')->find(1));
    }
}