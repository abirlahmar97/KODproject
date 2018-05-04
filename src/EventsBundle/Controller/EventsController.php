<?php

namespace EventsBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use EventsBundle\Entity\Event;
use EventsBundle\Entity\Reservation;
use EventsBundle\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventsController extends Controller
{

    public function createEventAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form = $form->handleRequest($request);
        if ($request->getMethod() == 'POST' && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $event = $form->getData();
            $user = $this->getDoctrine()->getRepository('UserBundle:User')->find($this->getUser()->getId());
            $event->setUser($user);
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('add_event');
        }
        return $this->render('@Events/Event/form.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Ajouter'
        ));
    }

    public function createApiEventAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form = $form->handleRequest($request);
        if ($request->getMethod() == 'POST' && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $event = $form->getData();
            $user = $this->getDoctrine()->getRepository('UserBundle:User')->find($this->getUser()->getId());
            $event->setUser($user);
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('add_event');
        }
        $data = $this->get("jms_serializer")->serialize($event, "json");
        return new Response($data);
        ;
    }

    public function ReservAction(Request $request)
    {
        $id = $request->get('event');
        $places = $request->get('places');
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository(Event::class)->find($id);
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

    public function ReservActionApi(Request $request)
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


    public function deleteEventAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository("EventsBundle:Event")->find($id);
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute("events_list");
    }

    public function deleteApiEventAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository("EventsBundle:Event")->find($id);
        $em->remove($event);
        $em->flush();
        $data = $this->get("jms_serializer")->serialize($event, "json");
        return new Response($data);

    }


    public function updateEventAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository("EventsBundle:Event")->find($id);
        $form = $this->createForm(EventType::class, $event);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('events_list');

        }
        return $this->render('EventsBundle:Event:updateEvent.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Modifier'
        ));
    }

    public function updateApiEventAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository("EventsBundle:Event")->find($id);
        $form = $this->createForm(EventType::class, $event);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('events_list');

        }
        $data = $this->get("jms_serializer")->serialize($event, "json");
        return new Response($data);
        ;
    }
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository(Event::class)->findAll();
        $paginator = $this->get('knp_paginator');
        $events = $paginator->paginate(
            $event,
            $request->query->getInt('page', 1), 4);
        return $this->render('@Events/Event/list.html.twig', array(
            'events' => $events,
            'pagination' => $paginator
        ));
    }

    public function listApiAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository(Event::class)->findAll();
        $data = $this->get("jms_serializer")->serialize($event, "json");
        return new Response($data);
    }

    public function readmoreApiAction($id)
    {
        $event = $this->getDoctrine()->getRepository("EventsBundle:Event")->find($id);
        $data = $this->get("jms_serializer")->serialize($event, "json");
        return new Response($data);
    }

    public function detailsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $parent = $em->getRepository("EventsBundle:Event")->find($id);
        return $this->render('EventsBundle:Event:details.html.twig', array(
            'event' => $parent
        ));
    }

    public function detailsApiAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $parent = $em->getRepository("EventsBundle:Event")->find($id);
        $data = $this->get("jms_serializer")->serialize($parent, "json");
        return new Response($data);
        ;
    }

    public function statAction()
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('EventsBundle:Event')->findAll();
        $titles = array();
        $views = array();
        foreach ($articles as $article) {
            array_push($titles, $article->getPlaces());
            array_push($views, $article->getLeftPlaces());
        }

        $bar = new BarChart();
        $bar->getData()->setArrayToDataTable([$titles, $views]);
        dump($bar);

        $bar->getOptions()->setTitle('Statistique sur les Categorie');
        $bar->getOptions()->getHAxis()->setTitle('Nombre des Sujet');
        $bar->getOptions()->getHAxis()->setMinValue(0);
        $bar->getOptions()->getVAxis()->setTitle('Categorie');
        $bar->getOptions()->setWidth(900);
        $bar->getOptions()->setHeight(500);

        $bar = new BarChart();
        $bar->getData()->setArrayToDataTable([$titles, $views]);
        $bar->getOptions()->setTitle('Statistique sur les Categorie');
        $bar->getOptions()->getHAxis()->setTitle('Nombre des Sujet');
        $bar->getOptions()->getHAxis()->setMinValue(0);
        $bar->getOptions()->getVAxis()->setTitle('Categorie');
        $bar->getOptions()->setWidth(900);
        $bar->getOptions()->setHeight(500);
        return $this->render('EventsBundle:Event:stat.html.twig', array('barchart' => $bar));
    }
}
