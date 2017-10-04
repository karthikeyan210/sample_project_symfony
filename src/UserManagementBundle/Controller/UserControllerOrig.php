<?php

// src/UserManagement/Controller/UserController.php
namespace UserManagementBundle\Controller;

use UserManagementBundle\Entity\User;
use UserManagementBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class UserController extends Controller
{
    public function formAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return new Response($user->getId());
        }
        return $this->render('UserManagementBundle:user:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function successAction()
    {
        return $this->render('@UserManagement/Default/link.html.twig');
    }
    
    public function listAction()
    {           
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('UserManagementBundle:User');
        $users = $repo->findAll();
        return $this->render('UserManagementBundle:form:list.html.twig', array(
            'users' => $users,
        ));
    }
    
    public function showAction($id)
    {           
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('UserManagementBundle:User');
        $user = $repo->find($id);
        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }
        return $this->render('UserManagementBundle:form:show.html.twig', array(
            'user' => $user,
        ));
    }
    
    public function editAction($id, Request $request)
    {       
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('UserManagementBundle:User');
        $userProfile = $repo->find($id);
        if (!$userProfile) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }
//        if ($user == null) {
//            echo "No user Found";
//            die();
//        }        
        $form = $this->createForm(UserType::class, $userProfile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userProfile = $form->getData();
            $em->flush();
            return new Response($userProfile->getId());
        }
        
        return $this->render('UserManagementBundle:form:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function addBloodAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $blood_group = new BloodGroup();
        if ($request->isMethod('POST')) {
            $blood = $request->request->get('blood_group');
            $blood_group->setName($blood);
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository('UserManagementBundle:BloodGroup');
            $result = $repo->findOneBy(array(
                'name' => $blood
            ));
            dump($result); die();
            if (!$result) {
                $em->persist($blood_group);
                $em->flush();
                return $this->redirectToRoute('user_management_gender');
            } else {
                return $this->redirectToRoute('user_management_addBlood');
            }
        }
        return $this->render('UserManagementBundle:user:addBlood.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
