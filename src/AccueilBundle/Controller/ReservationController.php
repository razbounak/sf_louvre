<?php

namespace AccueilBundle\Controller;

use AccueilBundle\Entity\Billet;
use AccueilBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AccueilBundle\Form\ReservationType;

class ReservationController extends Controller
{
    /**
     * @Route("/")
     */
    public function dateAction()
    {
        return $this->render('AccueilBundle:Reservation:date.html.twig');
    }

    public function billetAction(Request $request, $date, $dj, $places)
    {
        $reservation = new Reservation();

        $i = 0;
        while($i != $places) {
            $billet[$i] = new Billet();
            $reservation->getBillet()->add($billet[$i]);
            $billet[$i]->setReservation($reservation);
            $i++;
        }

        $form = $this->createForm(ReservationType::class, $reservation);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $i = 0;
            while($i != $places)
            {
                $em->persist($billet[$i]);
                $i++;
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