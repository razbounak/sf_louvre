<?php

namespace AccueilBundle\Controller;

use AccueilBundle\Entity\Billet;
use AccueilBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AccueilBundle\Form\ReservationType;

class ReservationController extends Controller
{
    public function dateAction()
    {
        return $this->render('AccueilBundle:Reservation:date.html.twig');
    }

    public function billetAction(Request $request, $date, $dj, $places)
    {
        $em = $this->getDoctrine()->getManager();
        $datetime = new \DateTime();
        $prix_total = 0;

        // Si plus de 1000 billets ont été vendus, on redirige vers la page de réservation
        $nb_billets = $em->getRepository('AccueilBundle:Billet')->getReservationDay($date);
        if(($places + $nb_billets) > 1000)
        {
            return $this->redirectToRoute('reservation_date');
        }

        $reservation = new Reservation();

        // On crée autant de billet que demandé
        for($i = 0; $i != $places; $i++) {
            $billet[$i] = new Billet();
            $reservation->getBillet()->add($billet[$i]);
            $billet[$i]->setReservation($reservation);
        }

        $form = $this->createForm(ReservationType::class, $reservation);

        // On enregistre la réservation et les billets
        if ($form->handleRequest($request)->isValid()) {
            $reservation->setDemiJournee($dj);
            $date = date_create_from_format('Y-m-d', $date);
            $reservation->setDateResa($date);
            for($i = 0; $i != $places; $i++)
            {
                $dateBebe = clone $billet[$i]->getDateNaissance();
                $dateSenior = clone $billet[$i]->getDateNaissance();
                $dateEnfant = clone $billet[$i]->getDateNaissance();
                $dateBebe->add(new \DateInterval('P4Y'));
                $dateSenior->add(new \DateInterval('P60Y'));
                $dateEnfant->add(new \DateInterval('P12Y'));
                if($dateBebe > $datetime)
                    $billet[$i]->setTarifs($em->getRepository('AccueilBundle:Tarifs')->find(6));
                elseif($dateBebe < $datetime && $dateEnfant > $datetime)
                    $billet[$i]->setTarifs($em->getRepository('AccueilBundle:Tarifs')->find(2));
                elseif($billet[$i]->getTarifReduit() === true)
                    $billet[$i]->setTarifs($em->getRepository('AccueilBundle:Tarifs')->find(4));
                elseif($dateSenior < $datetime)
                    $billet[$i]->setTarifs($em->getRepository('AccueilBundle:Tarifs')->find(3));
                else
                    $billet[$i]->setTarifs($em->getRepository('AccueilBundle:Tarifs')->find(1));
                $prix = $billet[$i]->getTarifs()->getPrix();
                $prix_total = $prix_total + $prix;
                $em->persist($billet[$i]);

            }
            $reservation->setPrixTotal($prix_total);
            $em->persist($reservation);
            $em->flush();

            return $this->redirect($this->generateUrl('recapitulatif', array('id' => $reservation->getId())));
        }

        return $this->render('AccueilBundle:Reservation:reservation.html.twig', array(
            'date' => $date,
            'dj' => $dj,
            'places' => $places,
            'form' => $form->createView()
        ));
    }

    public function recapAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository('AccueilBundle:Reservation')->find($id);

        return $this->render('AccueilBundle:Reservation:recap.html.twig', array(
            'reservation' => $reservation
        ));
    }
}
