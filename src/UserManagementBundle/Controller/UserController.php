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
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

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
//        $currentUser = $this->getUser()->getAttribute('userName');
//        dump($this->get('session')->getId()); die();

//        dump($currentUser); die();
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
            $em->flush();
            $this->addFlash("success", "Updated Successfully!!");
            return $this->redirectToRoute('user_management_show', array('id'=>$id));
        }
        
        return $this->render('UserManagementBundle:user:new.html.twig', array(
            'user' => $userProfile,
            'form' => $form->createView(),
        ));
    }
    
    public function csvImportAction(Request $request)
    {
        $file = $request->files->get('csvimport');
        $row = 0;
        $all_rows = array();
        $header = null;
        $em = $this->getDoctrine()->getManager();
        if (filesize($file)>0) {
            if (($handle = fopen($file, "r")) !== FALSE) {
                while (($data = fgetcsv($handle)) !== FALSE) {
                    if ($header === null) {
                        $header = $data;
                        continue;
                    }
                    $all_rows[] = array_combine($header, $data);
                }
                fclose($handle);
            }
        } else {
            $this->addFlash("warning", "Select the file!!");
            return $this->redirectToRoute('user_management_form');
        }
        echo '<pre>';
        print_r($all_rows);
        echo '</pre>';
        self::saveUser($all_rows);
        $this->addFlash("success", "Csv file imported successfully!!");
        return $this->redirectToRoute('user_management_list');
    }
    
    public function saveUser($all_rows)
    {
        $em = $this->getDoctrine()->getManager();
        foreach($all_rows as $row) {
            $userrepo = $em->getRepository('UserManagementBundle:User');
            $userProfile = $userrepo->findOneBy(array('username' => $row['username']));
            if (!$userProfile) {
                $userProfile = new User();
            }


            $bloodrepo = $em->getRepository('UserManagementBundle:BloodGroup');
            $blood = $bloodrepo->findOneBy(array('name' => $row['blood']));

            $genderrepo = $em->getRepository('UserManagementBundle:Gender');
            $gender = $genderrepo->findOneBy(array('name' => $row['gender']));

            $interests = explode(',', $row['interests']);
            for ($index = 0; $index < count($interests); $index++) {
                $interestrepo = $em->getRepository('UserManagementBundle:Interest');
                $interest = $interestrepo->findOneBy(array('name' => $interests[$index]));
                if ($interest === null) {
                    $interest = new \UserManagementBundle\Entity\Interest;
                    $interest->setName($interests[$index]);
                    $em->persist($interest);
                    $em->flush();
                    $interest = $interestrepo->findOneBy(array('name' => $interests[$index]));
                }
                $userinterestrepo = $em->getRepository('UserManagementBundle:UserInterest');
                $query = $em->createQuery(
                    'SELECT u
                    FROM UserManagementBundle:UserInterest u
                    WHERE u.user = :userid
                    AND u.interest = :interestid'
                )->setParameters(array('userid'=> $userProfile->getId(), 'interestid' => $interest->getId()));
                $userinterest = $query->getResult();
                if (!$userinterest) {
                    $userinterest = new UserInterest();
                    $userinterest->setInterest($interest);
                    $userProfile->addInterest($userinterest);
                }
            }
            
            
            $educations = explode('/', $row['education']);
            foreach($educations as $edu) {
                $education = explode(',', $edu);
                
                $educationrepo = $em->getRepository('UserManagementBundle:EducationType');
                $edutype = $educationrepo->findOneBy(array('type' => $education[0]));
                if ($edutype === null) {
                    $edutype = new \UserManagementBundle\Entity\EducationType;
                    $edutype->setType($education[0]);
                    $em->persist($edutype);
                    $em->flush();
                    $edutype = $educationrepo->findOneBy(array('type' => $education[0]));
                }
                $query = $em->createQuery(
                    'SELECT u
                    FROM UserManagementBundle:UserEducation u
                    WHERE u.user = :userid
                    AND u.eduType = :typeid'
                )->setParameters(array('userid'=> $userProfile->getId(), 'typeid' => $edutype->getId()));
                $usereducation = $query->getResult();
                if (!$usereducation) {
                    $usereducation = new UserEducation();
                    $usereducation->setEduType($edutype);
                    $usereducation->setInstitute($education[1]);
                    $userProfile->addEducation($usereducation);
                }
                dump($usereducation);
            }
            
            
            $emails = explode(',', $row['emails']);
            for ($index = 0; $index < count($emails); $index++) {
                $emailrepo = $em->getRepository('UserManagementBundle:UserEmail');
                $email = $emailrepo->findOneBy(array('emailAddr' => $emails[$index]));
                if (!$email) {
                    $email = new UserEmail();
                    $email->setEmailAddr($emails[$index]);
                    $userProfile->addEmail($email);
                }
            }
            
            
            $mobileNumbers = explode(',', $row['mobileNumbers']);
            for ($index = 0; $index < count($mobileNumbers); $index++) {
                $phonerepo = $em->getRepository('UserManagementBundle:UserPhone');
                $number = $phonerepo->findOneBy(array('number' => $mobileNumbers[$index]));
                if (!$number) {
                    $number = new UserPhone();
                    $number->setNumber($mobileNumbers[$index]);
                    $userProfile->addMobileNumber($number);
                }
            }

            $userProfile
                ->setUsername($row['username'])
                ->setFirstname($row['firstname'])
                ->setLastname($row['lastname'])
                ->setDob(new \DateTime($row['dob']))
                ->setBlood($blood)
                ->setGender($gender)
            ;
            $em->persist($userProfile);
            $em->flush();
            dump($userProfile);
        }
    }

    public function csvExportAction()
    {
        $response = new StreamedResponse();
        $response->setCallback(function() {
            $handle = fopen('php://output', 'w+');

            fputcsv($handle, array('username', 'firstname'));
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository('UserManagementBundle:User');
            $results = $repo->findAll();
            foreach ($results as $result) {
                $data = array($result->getUserName(), $result->getFirstName());
                fputcsv($handle, $data);
            }

            fclose($handle);
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="export.csv"');

        return $response;
    }
    
    
    public function autocompleteAction(Request $request)
    {
        $names = array();
        $term = trim(strip_tags($request->get('term')));
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UserManagementBundle:Interest')->createQueryBuilder('i')
           ->where('i.name LIKE :name')
           ->setParameter('name', '%'.$term.'%')
           ->getQuery()
           ->getResult();

        foreach ($entities as $entity)
        {
            $names[] = $entity->getName();
        }

        $response = new JsonResponse();
        $response->setData($names);

        return $response;
    }


}
