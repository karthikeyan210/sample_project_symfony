<?php

// src/UserManagement/Controller/UserController.php
namespace UserManagementBundle\Controller;

use UserManagementBundle\Entity\User;
use UserManagementBundle\Form\UserType;
use UserManagementBundle\Entity\UserEducation;
use UserManagementBundle\Entity\EducationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class UserController extends Controller
{
    public function formAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
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
        echo "Users List:<br>";
//        foreach ($users as $user) {
//            echo $user->getUsername() . "<br>";
//        }
//        die();
//        return new Response(serialize($repo));
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
//        echo $user->getUsername() . "<br>";
//        die();
//        return new Response(serialize($repo));
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
        
//        echo $user->getUsername() . "<br>";
//        die();
//        return new Response(serialize($repo));
        
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $em = $this->getDoctrine()->getManager();
//            $em->persist($user);
            $em->flush();
            return new Response($user->getId());
        }
        
        return $this->render('UserManagementBundle:form:editform.html.twig', array(
            'user' => $userProfile,
            'form' => $form->createView(),
        ));
    }
}
