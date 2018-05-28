<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;

class UsersController extends Controller
{
    public function billsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository('ShopBundle:Order')->byFacture($this->getUser());

        return $this->render('UserBundle:Home:bill.html.twig', array(
            'orders' => $orders
        ));
    }

    public function getUserAction()
    {
        $user = $this->get("jms_serializer")->serialize($this->getUser(), 'json');
        return new Response($user);
    }

    public function subscribeApiAction(Request $request){
        $email = $request->get("email");
        $login = $request->get("login");
        $pass = $request->get("pass");
        if($this->getDoctrine()->getRepository("UserBundle:User")->findBy(['usernameCanonical' => strtolower($login)]) != null)
            return new Response("Nom d'utilisateur utilisé", 440);
        if($this->getDoctrine()->getRepository("UserBundle:User")->findBy(['emailCanonical' => strtolower($email)]) != null)
            return new Response("L'addresse email existe deja", 445);
        else {
            $this->get('fos_user.util.user_manipulator')->create(
                $login,
                $pass,
                $email,
                true,false
            );
            $this->get('fos_user.util.user_manipulator')->addRole($login, "ROLE_PARENT");
            return new Response(200);
        }
    }
}
