<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Order;
use ShopBundle\Entity\ProductOrder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OrdersController extends Controller
{

    public function bill()
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('session');
        $cart = $session->get('cart');
        $products = $em->getRepository('ShopBundle:Product')->findArray(array_keys($session->get('cart')));
        $pos = [];
        foreach ($products as $product) {
            $po = new ProductOrder();
            $provider = $em->getRepository("UserBundle:User")->find($product->getUser()->getId());
            $user = $this->getUser();
            $po->setProduct($product);
            $po->setProvider($provider);
            $po->setUser($user);
            $po->setQuantity($product->getPrice() * $cart[$product->getId()]);
            $price = ($product->getPrice() * $cart[$product->getId()]);
            $po->setPrice($price);
            $pos[] = $po;
//            $order['product'][$product->getId()] = array(
//                'reference' => $product->getName(),
//                'quantity' => $cart[$product->getId()],
//                'priceTF' => round($product->getPrice(), 2)
//            );
        }

//        $order['shipping_add'] = array(
//            'address' => $shipping_add->getAddress(),
//            'postalCode' => $shipping_add->getPostalCode(),
//            'region' => $shipping_add->getRegion()
//        );
//
//        $order['billing_add'] = array(
//            'address' => $billing_add->getAddress(),
//            'postalCode' => $billing_add->getPostalCode(),
//            'region' => $billing_add->getRegion()
//        );
//        $order['priceTF'] = round($totalTF, 2);
//        $order['token'] = bin2hex(random_bytes(20));

        return $pos;
    }

    public function prepareOrderAction()
    {
//        if (!$session->has('order'))
//            $order = new Order();
//        else
//            $order = $em->getRepository('ShopBundle:Order')
//                ->find($session->get('order')->getId());
//        if (!$session->has('order')) {
//            $em->persist($order);
////            $session->set('order', $order);
//        }
        $session = $this->get('session');
        if(!$session->has('order')){
            $em = $this->getDoctrine()->getManager();
            $order = new Order();
            $addresses = $session->get('addresses');
            $billing_add = $em->getRepository('ShopBundle:UserAddress')->find($addresses['billing_add']);
            $shipping_add = $em->getRepository('ShopBundle:UserAddress')->find($addresses['shipping_add']);

            $order->setUser($this->getUser());
            $order->setBillAddr($billing_add);
            $order->setShipAddr($shipping_add);

            $pos = $this->bill();

            $totalTF = 0;
            foreach ($pos as $po){
                $totalTF += $po->getPrice();
                $po->setOrder($order);
            }

            if ($session->get('coupon') ) {
                $code = $session->get('coupon');
                $coupon = $this->getDoctrine()->getRepository("ShopBundle:Coupons")->findOneBy(['code' => $code]);
                if ($coupon != null)
                    $totalTF = $totalTF - ($totalTF * $coupon->getPercent() / 100);
            }

            $order->setTotal($totalTF);
            $order->setToken(bin2hex(random_bytes(20)));
            $em->persist($order);
            foreach ($pos as $po)
                $em->persist($po);
            $em->flush();
            $session->set('order', $order->getId());
        }
        else
            return new Response($session->get('order'));

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

        $session->remove('addresses');
        $session->remove('cart');
        $session->remove('order');

        $session->getFlashBag()->add('success', 'Votre commande est validé avec succès');
        return $this->redirect($this->generateUrl('bills'));
    }


    public function billpdfAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository("ShopBundle:Order")->find($id);
        $pos = $em->getRepository("ShopBundle:ProductOrder")->findBy(['order' => $order]);

        if (!$order) {
            $this->get('session')->getFlashBag()->add('error', 'Une erreur est survenue');
            return $this->redirect($this->generateUrl('bills'));
        }
        $html = $this->renderView('UserBundle:Home:billpdf.html.twig', array(
            'order' => $order,
            'pos' => $pos
        ));

        $snappy = $this->get('knp_snappy.pdf');
        $filename = 'Commande:' . $order->getReference();

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }
}
