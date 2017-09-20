<?php

// src/SampleBundle/Controller/FormController.php
namespace SampleBundle\Controller;

use SampleBundle\Entity\Task;
use SampleBundle\Form\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FormController extends Controller
{
    // public function newAction(Request $request)
    // {
    //     // create a task and give it some dummy data for this example
    //     $task = new Task();
    //     $task->setTask('Write a blog post');
    //     $task->setDueDate(new \DateTime('tomorrow'));

    //     $form = $this->createFormBuilder($task)
    //         ->add('task', TextType::class)
    //         ->add('dueDate', DateType::class)
    //         ->add('save', SubmitType::class, array('label' => 'Create Post'))
    //         ->getForm();

    //     return $this->render('SampleBundle:Default:new.html.twig', array(
    //         'form' => $form->createView(),
    //     ));
    // }
    /*
     * @Route("/form/create", name="form_create")
     */

    public function createAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $task = new Task();
        
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

        return $this->render('SampleBundle:form:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function successAction()
    {
        // echo "Form was submitted successfully!";
        return $this->render('SampleBundle:form:success.html.twig');
    }
}
