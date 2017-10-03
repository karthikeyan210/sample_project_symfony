<?php

// src/UserManagement/Controller/UserController.php
namespace UserManagementBundle\Controller;

use UserManagementBundle\Entity\User;
use UserManagementBundle\Form\UserType;
use UserManagementBundle\Entity\UserEmail;
use UserManagementBundle\Entity\UserPhone;
use UserManagementBundle\Entity\UserInterest;
use UserManagementBundle\Entity\UserEducation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function formAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $user = new User();
        $user->addEmail(new UserEmail());
        $user->addEducation(new UserEducation());
        $user->addInterest(new UserInterest());
        $user->addMobileNumber(new UserPhone());
 
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user_management_list');
//            return new Response("User is saved. id=" .$user->getId());
        }
        return $this->render('UserManagementBundle:user:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function successAction()
    {
        return $this->render('@UserManagement/Default/link.html.twig');
    }
    
    public function listAction($page = 1)
    {           
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserManagementBundle:User')
                    ->getAllUsers($page);
        $totalUsers = $users->count();
        $limit = 5;
        $maxPages = ceil($totalUsers / $limit);
        $thisPage = $page;
       return $this->render('UserManagementBundle:user:list.html.twig', array(
            'users' => $users,
            'maxPages' => $maxPages,
           'thisPage' => $thisPage,
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
        
        $form = $this->createForm(UserType::class, $userProfile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userProfile = $form->getData();
            $em->flush();
            return $this->redirectToRoute('user_management_show', array('id'=>$id));
//            return new Response("Updated the user Profile. id=" . $userProfile->getId());
        }
        
        return $this->render('UserManagementBundle:form:new.html.twig', array(
            'user' => $userProfile,
            'form' => $form->createView(),
        ));
    }
    
    
}
