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
        $data = array();
        $form = $this->createFormBuilder($data)
            ->add('date', DateType::class)
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $data = $form->getData();
        }

        return $this->render('AccueilBundle:Reservation:date.html.twig', array(
            'date' => $form->createView()
        ));
    }
}