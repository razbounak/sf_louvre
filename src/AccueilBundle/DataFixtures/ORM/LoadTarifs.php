<?php

namespace AccueilBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AccueilBundle\Entity\Tarifs;

class LoadTarifs implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $tab = array(
            array('nom' => 'Normal', 'info' => 'à partir de 12 ans', 'prix' => '16'),
            array('nom' => 'Enfant', 'info' => 'Un tarif « enfant » à partir de 4 ans et jusqu’à 12 ans (l’entrée est gratuite pour les enfants de moins de 4 ans)', 'prix' => '8'),
            array('nom' => 'Senior', 'info' => 'à partir de 60 ans', 'prix' => '12'),
            array('nom' => 'Réduit', 'info' => 'accordé dans certaines conditions (étudiant, employé du musée, d’un service du Ministère de la Culture, militaire…)', 'prix' => '10'),
            array('nom' => 'Famille', 'info' => '2 adultes et 2 enfants ayant le même nom de famille', 'prix' => '35'),
            array('nom' => 'Enfant', 'info' => 'Un tarif « enfant » à partir de 4 ans et jusqu’à 12 ans (l’entrée est gratuite pour les enfants de moins de 4 ans)', 'prix' => '0'),
        );

        foreach ($tab as $row) {
            $tarifs = new Tarifs();

            // Ajouter Slug
            
            $tarifs->setNom($row['nom']);
            $tarifs->setInfo($row['info']);
            $tarifs->setPrix($row['prix']);

            $manager->persist($tarifs);
        }
        $manager->flush();
    }
}