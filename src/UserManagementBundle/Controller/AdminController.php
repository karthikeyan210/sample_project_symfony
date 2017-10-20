<?php

// src/UserManagement/Controller/UserController.php
namespace UserManagementBundle\Controller;

use UserManagementBundle\Entity\User;
use UserManagementBundle\Form\UserType;
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

class AdminController extends Controller
{
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
    
    public function filterByDateAction(Request $request, $page = 1)
    {
        $start = $request->request->get('startday');
        $end = $request->request->get('endday');
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserManagementBundle:User')
                    ->filterByDate($start, $end, $page);
        $totalUsers = $users->count();
        if ($totalUsers == 0) {
            return new Response("<b>select valid duration</b>");
        }
        $limit = 5;
        $maxPages = ceil($totalUsers / $limit);
        $thisPage = $page;
        return $this->render('UserManagementBundle:user:userlist.html.twig', array(
            'users' => $users,
            'maxPages' => $maxPages,
           'thisPage' => $thisPage,
        ));

    }
   
}
