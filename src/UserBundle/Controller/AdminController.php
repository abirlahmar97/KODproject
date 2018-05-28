<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use UserBundle\Entity\UserInfos;
use UserBundle\Form\UserType;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('UserBundle:Admin/Home:index.html.twig');
    }

    public function listUsersAction(){
        $users = $this->getDoctrine()->getRepository("UserBundle:User")->findAll();
        return $this->render("UserBundle:Admin/Users:list.html.twig", [
            'users' => $users
        ]);
    }

    public function addUserAction(Request $request){
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        if($request->getMethod() == 'POST' && $form->handleRequest($request)->isValid()){

            $this->get('fos_user.util.user_manipulator')->create(
                $user->getUsername(),
                $user->getPassword(),
                $user->getEmail(),
                true,false
            );
            $this->get('fos_user.util.user_manipulator')->addRole($user->getUsername(), $user->getRoles()[0]);
            $request->getSession()->getFlashBag()->add('notice', "L'utilisateur a été crée avec succes");
            return $this->redirectToRoute('users_list');
        }
        return $this->render('UserBundle:Admin/Users:create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function deleteUserAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->find($id);
        $em->remove($user);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', "L'utilisateur a été supprimé avec succes");
        return $this->redirectToRoute('users_list');
    }

    public function deleteUsersBulkAction(Request $request){
        $users = $request->get('users');
        $users = explode(',', $users);
        $em = $this->getDoctrine()->getManager();
        foreach ($users as $id){
            $user = $em->getRepository('UserBundle:User')->find($id);
            $em->remove($user);
        }
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', "Les utilisateurs sélectionnés on été supprimés avec succes");
        return $this->redirectToRoute('users_list');
    }

    public function disableUserAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->find($id);
        $user->setEnabled(false);
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', "L'utilisateur a été désactivé");
        return $this->redirectToRoute('users_list');
    }

    public function disableUsersBulkAction(Request $request){
        $users = $request->get('users');
        $users = explode(',', $users);
        $em = $this->getDoctrine()->getManager();
        foreach ($users as $id){
            $user = $em->getRepository('UserBundle:User')->find($id);
            $user->setEnabled(false);
        }
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', "L'utilisateur a été désactivés");
        return $this->redirectToRoute('users_list');
    }

    public function enableUsersBulkAction(Request $request){
        $users = $request->get('users');
        $users = explode(',', $users);
        $em = $this->getDoctrine()->getManager();
        foreach ($users as $id){
            $user = $em->getRepository('UserBundle:User')->find($id);
            $user->setEnabled(true);
        }
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', "Les utilisateurs a sélectionnés ont été activés");
        return $this->redirectToRoute('users_list');
    }

    public function addUsersAction(Request $request){
        $data = $request->getContent();
        $users = $this->get("jms_serializer")->deserialize($data, "array<UserBundle\Entity\User>", 'json');
        $em = $this->getDoctrine()->getManager();
        foreach ($users as $user){
            $this->get('fos_user.util.user_manipulator')->create(
                $user->getUsername(),
                $user->getUsername(),
                $user->getEmail(),
                true,false
            );
            $this->get('fos_user.util.user_manipulator')->addRole($user->getUsername(), $user->getRoles()[0]);
            $userInfos = $user->getInfos();
            $newUserInfos = new UserInfos();
            $newUserInfos->setFirstname($userInfos->getFirstname());
            $newUserInfos->setLastname($userInfos->getLastname());
            $newUserInfos->setPhone($userInfos->getPhone());
            $newUserInfos->setRegion($userInfos->getRegion());

            $newuser = $em->getRepository("UserBundle:User")->findOneBy(['username' => $user->getUsername()]);
            $newuser->setInfos($newUserInfos);

            $em->persist($newuser);
            $em->flush();
        }
        return new Response();
    }
}
