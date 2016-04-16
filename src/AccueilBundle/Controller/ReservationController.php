<?php

namespace AccueilBundle\Controller;

use AccueilBundle\AccueilBundle;
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
            $em->persist($reservation);
            for($i = 0; $i != $places; $i++)
            {
                $em->persist($billet[$i]);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('accueil_homepage'));
        }

        return $this->render('AccueilBundle:Reservation:reservation.html.twig', array(
            'date' => $date,
            'dj' => $dj,
            'places' => $places,
            'form' => $form->createView()
        ));
    }
}