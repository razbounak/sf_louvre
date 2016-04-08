<?php

namespace AccueilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AccueilBundle\Form\DatepickType;

class ReservationController extends Controller
{
    /**
     * @Route("/")
     */
    public function dateAction(Request $request)
    {
        $form = $this->createForm(DatepickType::class);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
        }

        return $this->render('AccueilBundle:Reservation:date.html.twig', array(
            'date' => $form->createView()
        ));
    }
}