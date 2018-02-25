<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OrdersController extends Controller
{

    public function bill(SessionInterface $session)
    {
        $em = $this->getDoctrine()->getManager();
        $address = $session->get('address');
        $cart = $session->get('cart');
        $order = array();
        $totalTF = 0;

        $billing_add = $em->getRepository('ShopBundle:UserAddress')->find($address['billing_add']);
        $shipping_add = $em->getRepository('ShopBundle:UserAddress')->find($address['shipping_add']);
        $products = $em->getRepository('ShopBundle:Product')->findArray(array_keys($session->get('cart')));

        foreach ($products as $product) {
            $priceTF = ($product->getPrice() * $cart[$product->getId()]);
            $totalTF += $priceTF;

            $order['product'][$product->getId()] = array(
                'reference' => $product->getName(),
                'quantity' => $cart[$product->getId()],
                'priceTF' => round($product->getPrice(), 2)
            );
        }

        $order['shipping_add'] = array(
            'address' => $shipping_add->getAddress(),
            'postalCode' => $shipping_add->getPostalCode(),
            'region' => $shipping_add->getRegion()
        );

        $order['billing_add'] = array(
            'address' => $billing_add->getAddress(),
            'postalCode' => $billing_add->getPostalCode(),
            'region' => $billing_add->getRegion()
        );
        $order['priceTF'] = round($totalTF, 2);
        $order['token'] = bin2hex(random_bytes(20));

        return $order;
    }

    public function prepareOrderAction(SessionInterface $session)
    {
        $em = $this->getDoctrine()->getManager();
        if (!$session->has('order'))
            $order = new Order();
        else
            $order = $em->getRepository('ShopBundle:Order')
                ->find($session->get('order')->getId());

        $order->setDate(new \DateTime());
        $order->setUser($this->getUser());
        $order->setConfirmed(0);
        $order->setReference(0);
        $order->setOrder($this->bill($session));

        if (!$session->has('order')) {
            $em->persist($order);
            $session->set('order', $order);
//            die();
        }
        $em->flush();
        return new Response($order->getId());
    }

    public function confirmationAction($id, SessionInterface $session)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('ShopBundle:Order')->find($id);

        if (!$order || $order->getConfirmed() == 1)
            throw $this->createNotFoundException('La commande n\'existe pas');

        $order->setConfirmed(1);
        $order->setReference($this->container->get('set.new.reference')->reference());
        $em->flush();

        $session->remove('address');
        $session->remove('cart');
        $session->remove('order');

        $this->get('session')->getFlashBag()->add('success', 'Votre commande est validé avec succès');
        return $this->redirect($this->generateUrl('bills'));
    }

}
