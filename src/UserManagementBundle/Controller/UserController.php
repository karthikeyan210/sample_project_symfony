<?php

// src/UserManagement/Controller/UserController.php
namespace UserManagementBundle\Controller;

use UserManagementBundle\Entity\Task;
use UserManagementBundle\Form\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class UserController extends Controller
{
    public function formAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $task = new Task();
        $task->setEmails(['']);
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $em = $this->getDoctrine()->getManager();
            // $em->persist($task);
            // $em->flush();

            return $this->redirectToRoute('form_success');
        }

        return $this->render('UserManagementBundle:form:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function successAction()
    {
        // echo "Form was submitted successfully!";
        return $this->render('@UserManagement/Default/link.html.twig');
    }

    public function userAction()
    {
        $users = [
            [
                "name" => "Molecule Man",
                "age" => 29,
            ],
            [
                "name" => "Karthikeyan",
                "age" => 21,
            ],
            [
                "name" => "Aadhil Ahmed",
                "age" => 22,
            ],
        ];
        return $this->render('UserManagement:Default:user.html.twig', array(
            'users' => $users,
        ));
    }
}
