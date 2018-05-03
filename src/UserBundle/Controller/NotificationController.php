<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Notification;

class NotificationController extends Controller
{
    public function api_complaint_notificationAction()
    {
        $em = $this->getDoctrine()->getManager();
        $notifications = $em->getRepository("UserBundle:Notification")->findByUser($this->getUser());
        $data= $this->get("jms_serializer")->serialize($notifications,'json');
        return new Response($data);



    }
    public function api_updateAction(Request $request)
    {

        $data = $request->getContent();
        $pos = $this->get("jms_serializer")->deserialize($data, "UserBundle\Entity\Notification", "json");
        $em = $this->getDoctrine()->getManager();
        $notification = $em->getRepository("UserBundle:Notification")->find($pos->getId());
        $notification->setState(true);
        $em->persist($notification);
        $em->flush();


        return new Response();
    }
    public function api_deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $notification = $em->getRepository("UserBundle:Notification")->find($id);
        dump($notification);
        $em->remove($notification);
        $em->flush();


        return new Response();
    }








}
