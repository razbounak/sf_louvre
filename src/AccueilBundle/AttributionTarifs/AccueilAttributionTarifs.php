<?php

namespace AccueilBundle\AttributionTarifs;

use AccueilBundle\Entity\Billet;
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
            $tarifsId = 6;
        elseif ($dateBebe < $datetime && $dateEnfant > $datetime)
            $tarifsId = 2;
        elseif ($billet->getTarifReduit() === true)
            $tarifsId = 4;
        elseif ($dateSenior < $datetime)
            $tarifsId = 3;
        else
            $tarifsId = 1;

        $billet->setTarifs($this->em->getRepository('AccueilBundle:Tarifs')->find($tarifsId));
    }
}