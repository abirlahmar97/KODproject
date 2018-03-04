<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\UserAddress;
use ShopBundle\Entity\UsersAdresses;
use ShopBundle\Form\UserAddressType;
use ShopBundle\Form\UsersAdressesType;
use ShopBundle\ShopBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UserBundle\Entity\UserInfos;
use UserBundle\Form\UserInfosType;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{

    public function addItemAction($id, Request $request, SessionInterface $session)
    {
        if (!$session->has('cart')) $session->set('cart', array());
        $cart = $session->get('cart');


        if (is_array($cart) && array_key_exists($id, $cart)) {
            if ($request->query->get('quantity') != null) $cart[$id] = $request->query->get('quantity');
            $this->get('session')->getFlashBag()->add('success', 'Quantité modifié avec succès');
        } else {
            if ($request->query->get('quantity') != null)
                $cart[$id] = $request->query->get('quantity');
            else
                $cart[$id] = 1;

            $this->get('session')->getFlashBag()->add('success', 'Article ajouté avec succès');
        }

        $session->set('cart', $cart);
        return $this->redirectToRoute('cart_show');

    }

    public function cartAction(Request $request, SessionInterface $session)
    {

        if (!$session->has('cart')) $session->set('cart', array());
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('ShopBundle:Product')->findArray(array_keys($session->get('cart')));

        return $this->render('ShopBundle:cart:show.html.twig', array(
            'products' => $products,
            'cart' => $session->get('cart')));
    }

    public function deleteItemAction($id, Request $request, SessionInterface $session)
    {
        $cart = $session->get('cart');

        if (array_key_exists($id, $cart)) {
            unset($cart[$id]);
            $session->set('cart', $cart);
            $this->get('session')->getFlashBag()->add('success', 'Article supprimé avec succès');
        }

        return $this->redirectToRoute('cart_show');
    }
    public function menuAction(SessionInterface $session)
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('ShopBundle:Product')->findAll();
        if (!$session->has('cart'))
            $count =0;
        else
            $count = count($session->get('cart'));

        return $this->render('ShopBundle:Cart:dropdown.html.twig', array(
            'count' => $count ,
            'products' => $products
        ));
    }

    public function shippingAction(Request $request)
    {
        $user= $this->getUser();

        $entity = new UserAddress();
        $form = $this->createForm(UserAddressType::class, $entity);
        if ($request->isMethod('POST') )
        {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity->setUser($user);
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('shipping'));
            }
        }

        return $this->render('ShopBundle:cart:shipping.html.twig', array(
            'user' => $user,
            'form' => $form->createView()
        ));
    }

    public function setShippingOnSession(SessionInterface $session,Request $request)
    {
        if (!$session->has('address')) $session->set('address',array());
            $address = $session->get('address');

        if ($request->get('shipping_add') != null && $request->get('billing_add') != null)
        {
            $address['shipping_add'] = $request->get('shipping_add');
            $address['billing_add'] = $request->get('billing_add');
        } else {
            return $this->redirect($this->generateUrl('cart_confirmation'));
        }
        $session->set('address',$address);
        return $this->redirect($this->generateUrl('cart_confirmation'));
    }


    public function confirmationAction(Request $request, SessionInterface $session)
    {
//        $session->remove('cart');
//        $session->remove('order');
//        $session->remove('address');
        if ($request->isMethod('POST') )
            $this->setShippingOnSession($session,$request);
        $em = $this->getDoctrine()->getManager();
        $prepareOrder = $this->forward('ShopBundle:Orders:prepareOrder');
//        var_dump($prepareOrder->getContent());
//        return new Response();
        $order = $em->getRepository('ShopBundle:Order')->find($prepareOrder->getContent());
        return $this->render('ShopBundle:cart:confirmation.html.twig', array(
            'order' => $order
        ));
    }


}
