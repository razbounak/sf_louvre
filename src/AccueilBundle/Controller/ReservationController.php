<?php

namespace AccueilBundle\Controller;

use AccueilBundle\Entity\Billet;
use AccueilBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AccueilBundle\Form\Type\ReservationType;

class ReservationController extends Controller
{
    public $em;

    public function __construct()
    {
        $em = $this->getDoctrine()->getManager();
    }

    public function dateAction()
    {
        return $this->render('AccueilBundle:Reservation:date.html.twig');
    }

    public function billetAction(Request $request, $date, $dj, $places)
    {
        $prix_total = 0;

        // Si plus de 1000 billets ont été vendus, on redirige vers la page de réservation
        $nb_billets = $em->getRepository('AccueilBundle:Billet')->getReservationDay($date);
        if(($places + $nb_billets) > 1000) {
            return $this->redirectToRoute('reservation_date');
        }

        $reservation = new Reservation();

        // On crée autant de billets que demandé
        for($i = 0; $i != $places; $i++) {
            $billets[$i] = new Billet();
            $reservation->getBillet()->add($billets[$i]);
            $billets[$i]->setReservation($reservation);
        }

        $form = $this->createForm(ReservationType::class, $reservation);

        // On enregistre la réservation et les billets
        if ($form->handleRequest($request)->isValid()) {
            $reservation->setDemiJournee($dj);
            $date = date_create_from_format('Y-m-d', $date);
            $reservation->setDateResa($date);
            for($i = 0; $i != $places; $i++)
            {
                // Attribution du tarif adapté à chaque personne
                $attribution = $this->container->get('accueil.attribution');
                $attribution->attributionTarifs($billets[$i]);

                $prix = $billets[$i]->getTarifs()->getPrix();
                $prix_total = $prix_total + $prix;
                $em->persist($billets[$i]);
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
