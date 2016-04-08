<?php

namespace AccueilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ReservationController extends Controller
{
    /**
     * @Route("/")
     */
    public function dateAction(Request $request)
    {
        $form = $this->createForm(DateType::class);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
        }

        return $this->render('AccueilBundle:Reservation:date.html.twig', array(
            'date' => $form->createView()
        ));
    }
}