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
//        $userEducation = new UserEducation();
//        $education = new EducationType();
//        $userEducation->setEduType($education);
//        $user->addEducation($userEducation);
//        $userInterest = new UserInterest();
//        $interest = new Interest();
//        $interest->setName('watching');
//        $userInterest->setInterest($interest);
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
}
