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
    /**
     * To render the form to create new user
     * 
     * @param Request $request
     * @return type
     */
    public function formAction(Request $request)
    {
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
            $this->addFlash("success", "User registration is success!!");
            return $this->redirectToRoute('user_management_form');
        }
        return $this->render('UserManagementBundle:user:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * To list the users
     * 
     * @param integer $page
     * @return type
     */
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
    
    /**
     * To retrieve the selected user based on the page number
     * 
     * @param integer $page
     * @return type
     */
    public function paginateAction($page = 1)
    {           
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserManagementBundle:User')
                    ->getAllUsers($page);
        $totalUsers = $users->count();
        $limit = 5;
        $maxPages = ceil($totalUsers / $limit);
        $thisPage = $page;
       return $this->render('UserManagementBundle:user:userlist.html.twig', array(
            'users' => $users,
            'maxPages' => $maxPages,
           'thisPage' => $thisPage,
        ));
    }
   
    /**
     * To display the user profile
     * 
     * @param integer $id
     * @return type
     * @throws type
     */
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
    
    /**
     * To render the form to edit the user profile
     * 
     * @param integer $id
     * @param Request $request
     * @return type
     * @throws type
     */
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
            $this->addFlash("success", "Updated Successfully!!");
            return $this->redirectToRoute('user_management_show', array('id'=>$id));
        }
        
        return $this->render('UserManagementBundle:user:new.html.twig', array(
            'user' => $userProfile,
            'form' => $form->createView(),
        ));
    }
    
    /** 
     * To manage the user interest,education and blood group details
     * 
     * @param Request $request
     * @return type
     */
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
        
    /**
     * To add the blood group
     * 
     * @param Request $request
     * @return type
     */
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
    
    /**
     * To add the user interest area
     * 
     * @param Request $request
     * @return type
     */
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
    
    /**
     * To add the education type
     * 
     * @param Request $request
     * @return type
     */
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