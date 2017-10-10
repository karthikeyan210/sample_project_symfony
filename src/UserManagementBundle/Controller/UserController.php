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
}
