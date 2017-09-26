<?php
// src/SampleBundle/Controller/TaskController.php
namespace SampleBundle\Controller;

use SampleBundle\Entity\Task;
use SampleBundle\Entity\Tag;
use SampleBundle\Form\Type\TaskType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function newAction(Request $request)
    {
        $task = new Task();

        // dummy code - this is here just so that the Task has some tags
        // otherwise, this isn't an interesting example
        $tag1 = new Tag();
        $tag1->setName('tag1');
        $task->getTags()->add($tag1);
        $tag2 = new Tag();
        $tag2->setName('tag2');
        $task->getTags()->add($tag2);
        // end dummy code

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            // ... maybe do some form processing, like saving the Task and Tag objects
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            return new Response('Saved new task with id '.$task->getId());
        }

        return $this->render('SampleBundle:task:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
