<?php

// src/UserManagement/Controller/UserController.php
namespace UserManagementBundle\Controller;

use UserManagementBundle\Entity\User;
use UserManagementBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\Pagination\Paginator;

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
    
    public function listAction($page = 1)
    {           
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('UserManagementBundle:User');
//        $users = $repo->findAll();
        echo "Users List:<br>";
//        foreach ($users as $user) {
//            echo $user->getUsername() . "<br>";
//        }
//        die();
//        return new Response(serialize($repo));
        // ... get posts from DB...
        // Controller Action
        $users = $repo->getAllUsers($page); // Returns 5 posts out of 20

        // You can also call the count methods (check PHPDoc for `paginate()`)
        # Total fetched (ie: `5` posts)
        $totalUsersReturned = $users->getIterator()->count();

        # Count of ALL posts (ie: `20` posts)
        $totalUsers = $users->count();

        # ArrayIterator
        $iterator = $users->getIterator();

        // render the view (below) 
        $limit = 5;
        $maxPages = ceil($paginator->count() / $limit);
        $thisPage = $page;
        // Pass through the 3 above variables to calculate pages in twig
//        return $this->render('view.twig.html', compact('categories', 'maxPages', 'thisPage'));
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
    
    /**
    * Our new getAllPosts() method
    *
    * 1. Create & pass query to paginate method
    * 2. Paginate will return a `\Doctrine\ORM\Tools\Pagination\Paginator` object
    * 3. Return that object to the controller
    *
    * @param integer $currentPage The current page (passed from controller)
    *
    * @return \Doctrine\ORM\Tools\Pagination\Paginator
    */
   public function getAllPosts($currentPage = 1)
   {
       // Create our query
       $query = $this->createQueryBuilder('p')
           ->orderBy('p.created', 'DESC')
           ->getQuery();

       // No need to manually get get the result ($query->getResult())

       $paginator = $this->paginate($query, $currentPage);

       return $paginator;
   }
    /**
     * Paginator Helper
     *
     * Pass through a query object, current page & limit
     * the offset is calculated from the page and limit
     * returns an `Paginator` instance, which you can call the following on:
     *
     *     $paginator->getIterator()->count() # Total fetched (ie: `5` posts)
     *     $paginator->count() # Count of ALL posts (ie: `20` posts)
     *     $paginator->getIterator() # ArrayIterator
     *
     * @param Doctrine\ORM\Query $dql   DQL Query Object
     * @param integer            $page  Current page (defaults to 1)
     * @param integer            $limit The total number per page (defaults to 5)
     *
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function paginate($dql, $page = 1, $limit = 5)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Offset
            ->setMaxResults($limit); // Limit

        return $paginator;
    }
}
