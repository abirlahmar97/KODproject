<?php

namespace EventsBundle\Controller;

use EventsBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReservationsController extends Controller
{

    public function reservationsAction(Request $request){
        $reservations = $this->getDoctrine()->getRepository("EventsBundle:Reservation")->findByUser($this->getUser()->getId());
        $paginator = $this->get('knp_paginator');
        $page = $paginator->paginate(
            $reservations,
            $request->query->getInt('page', 1), 4);
        return $this->render("EventsBundle:Event:reservations.html.twig", [
            'reservations' => $page
        ]);
    }

    public function ReserveAction(Request $request)
    {
        $id = $request->get('event');
        $places = $request->get('places');
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository("EventsBundle:Event")->find($id);
        $event->setPlaces($event->getPlaces() + $places);
        $event->setLeftPlaces($event->getLeftPlaces() - $places);
        $resv = new Reservation();
        $resv->setEvent($event);
        $resv->setParticipants($places);
        $user = $this->getUser();
        $resv->setUser($user);
        $em->persist($resv);
        $em->persist($event);
        $em->flush();
        return $this->redirectToRoute('events_list');
    }

    public function ReserveActionApi(Request $request)
    {
        $eid= $request->get("id");
        $places = $request->get("places");

        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository("EventsBundle:Event")->find($eid);
        $event->setPlaces($event->getPlaces() + $places);
        $event->setLeftPlaces($event->getLeftPlaces() - $places);
        $resv = new Reservation();
        dump($places);
        $resv->setEvent($event);
        $resv->setParticipants($places);
        $resv->setUser($this->getUser());
        $em->persist($resv);
        $em->persist($event);
        $em->flush();
        return new Response();
    }

    public function CancelAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository("EventsBundle:Reservation")->findEvent($id, $this->getUser()->getId());
        $em->remove($reservation);
        $em->flush();
        return $this->redirectToRoute("events_list");
    }
}
