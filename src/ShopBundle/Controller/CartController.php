<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Coupons;
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
            if ($request->query->get('qte') != null) {
                $cart[$id] = $request->query->get('qte');
                $this->get('session')->getFlashBag()->add('success', 'Quantité modifié avec succès');
            }
        } else {
            if ($request->query->get('qte') != null)
                $cart[$id] = $request->query->get('qte');
            else
                $cart[$id] = 1;

            $this->get('session')->getFlashBag()->add('success', 'Article ajouté avec succès');
        }

        $session->set('cart', $cart);
        return $this->redirectToRoute('cart_show');

    }

    public function cartAction(Request $request, SessionInterface $session)
    {

        if (!$session->has('cart')) 
            $session->set('cart', array());
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('ShopBundle:Product')->findArray(array_keys($session->get('cart')));

        return $this->render('ShopBundle:cart:show.html.twig', array(
            'products' => $products,
            'cart' => $session->get('cart')
        ));
    }

    private function getMax(){
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository('ShopBundle:Order')->getMax();
        $max=$result[0];
        foreach ($result as $i){
            if ($max['cou']<$i['cou']){
                $max=$i;
            }
        }
        return $max['user_id'];

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

    public function dropdownAction(SessionInterface $session)
    {
        $em = $this->getDoctrine()->getManager();
        if (!$session->has('cart')) 
            $session->set('cart', array());
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('ShopBundle:Product')->findArray(array_keys($session->get('cart')));

        if (!$session->has('cart'))
            $count =0;
        else
            $count = count($session->get('cart'));

        return $this->render('ShopBundle:Cart:dropdown.html.twig', array(
            'count' => $count ,
            'products' => $products,
            'cart' => $session->get('cart')));
    }

    public function  applyAction(Request $request){
        return $this->render('@Shop/Cart/show.html.twig');
    }

    public function applyCouponAction()
    {
    }

    public function shippingAction(Request $request,SessionInterface $session)
    {
        if ($request->isMethod('GET'))
        {
            $coupon=$request->get('coupon');
            if($coupon != '')
                $session->set('coupon',$coupon);

        }
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
            $addresses = $session->get('addresses');

        if ($request->get('shipping_add') != null && $request->get('billing_add') != null)
        {
            $addresses['shipping_add'] = $request->get('shipping_add');
            $addresses['billing_add'] = $request->get('billing_add');
        } else {
            return $this->redirect($this->generateUrl('cart_confirmation'));
        }
        $session->set('addresses',$addresses);
        return $this->redirect($this->generateUrl('cart_confirmation'));
    }


    public function confirmationAction(Request $request, SessionInterface $session)
    {
        if ($request->isMethod('POST') )
            $this->setShippingOnSession($session,$request);
        $em = $this->getDoctrine()->getManager();
        $prepareOrder = $this->forward('ShopBundle:Orders:prepareOrder');
        $order = $em->getRepository('ShopBundle:Order')->find($prepareOrder->getContent());
        $pos = $em->getRepository("ShopBundle:ProductOrder")->findBy(["order" => $order]);
        return $this->render('ShopBundle:cart:confirmation.html.twig', array(
            'order' => $order,
            'products' => $pos
        ));
    }

    public function deleteAddrAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ShopBundle:UserAddress')->find($id);

        if ( $user= $this->getUser() != $entity->getUser() || !$entity)
            return $this->redirect ($this->generateUrl ('shipping'));

        $em->remove($entity);
        $em->flush();

        return $this->redirect ($this->generateUrl ('shipping'));
    }

}

