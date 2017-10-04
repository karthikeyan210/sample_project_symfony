<?php

// src/UserManagement/Controller/UserController.php
namespace UserManagementBundle\Controller;

use UserManagementBundle\Entity\User;
use UserManagementBundle\Form\UserType;
use UserManagementBundle\Entity\UserEmail;
use UserManagementBundle\Entity\UserPhone;
use UserManagementBundle\Entity\UserInterest;
use UserManagementBundle\Entity\UserEducation;
use UserManagementBundle\Entity\BloodGroup;
use UserManagementBundle\Form\BloodGroupType;
use UserManagementBundle\Entity\Interest;
use UserManagementBundle\Form\InterestType;
use UserManagementBundle\Entity\EducationType;
use UserManagementBundle\Form\EduType;
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

//    public function successAction()
//    {
//        return $this->render('@UserManagement/Default/link.html.twig');
//    }
    
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
        return $this->render('UserManagementBundle:user:show.html.twig', array(
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
        
        return $this->render('UserManagementBundle:user:new.html.twig', array(
            'user' => $userProfile,
            'form' => $form->createView(),
        ));
    }
    
    public function genderAction()
    {
       $em = $this->getDoctrine()->getManager();
       $repo = $em->getRepository('UserManagementBundle:BloodGroup');
       $genders = $repo->findAll();
       dump($genders); die();
    }
    
    public function adminAction(Request $request)
    {
        $user = new User();
        $user->addEducation(new UserEducation());
        $user->addInterest(new UserInterest());
        
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        return $this->render('UserManagementBundle:user:admin.html.twig', array(
            'form' => $form->createView(),
        ));
    }
        
    public function addBloodGroupAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('UserManagementBundle:BloodGroup');
        $bloodgroup = $repo->findAll();
        $blood_group = new BloodGroup();
 
        $form = $this->createForm(BloodGroupType::class, $blood_group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blood_group = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($blood_group);
            $em->flush();
            return $this->redirectToRoute('user_management_admin');
        }
        return $this->render('UserManagementBundle:user:addBloodGroup.html.twig', array(
            'bloodgroups' => $bloodgroup,
            'form' => $form->createView(),
        ));
        
    }
    
    public function addInterestAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('UserManagementBundle:Interest');
        $interests = $repo->findAll();
        
        $interest = new Interest();
        $form = $this->createForm(InterestType::class, $interest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $interest = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($interest);
            $em->flush();
            return $this->redirectToRoute('user_management_admin');
        }
        return $this->render('UserManagementBundle:user:addInterest.html.twig', array(
            'interests' => $interests,
            'form' => $form->createView(),
        ));
        
    }
    
    public function addEducationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('UserManagementBundle:EducationType');
        $educationtypes = $repo->findAll();
        
        $education = new EducationType();
        $form = $this->createForm(EduType::class, $education);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $education = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($education);
            $em->flush();
            return $this->redirectToRoute('user_management_admin');
        }
        return $this->render('UserManagementBundle:user:addEducation.html.twig', array(
            'educationtypes' => $educationtypes,
            'form' => $form->createView(),
        ));
        
    }
}
