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
    
    public function csvImportAction()
    {
        return $this->render('UserManagementBundle:user:csvImport.html.twig');
    }
    
    /**
     * Create or update user profile using CSV file
     * 
     * @param Request $request
     * @return type
     */
    public function csvReadAction(Request $request)
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
                    if (count($data) != count($header)) {
                        $this->addFlash("warning", "Provide all the details for the user!!");
                        return $this->redirectToRoute('user_management_form');
                    }
                    $all_rows[] = array_combine($header, $data);
                }
                fclose($handle);
            }
        } else {
            $this->addFlash("warning", "Select the file!!");
            return $this->redirectToRoute('user_management_import');
        }
        
        $saveUser = $this->saveUser($all_rows);
        if (!$saveUser[1]) {
            $this->addFlash("warning", $saveUser[0]);
            return $this->redirectToRoute('user_management_import');
        }
        $this->addFlash("success", "Csv file imported successfully!!");
        return $this->redirectToRoute('user_management_list');
    }
    
    
    /**
     * To validate the date of birth 
     * 
     * @param type $dob
     * @return boolean
     */
    public function validateDob($dob)
    {
        $isValid = true;
        if (!preg_match("/^[\d]{2}[-][\d]{2}[-][\d]{4}$/", $dob, $matches)) {
            return false;
        }
       
        $dateofbirth = explode('-', $dob);
        $birthDay = $dateofbirth[0];
        $birthMonth = $dateofbirth[1];
        $birthYear = $dateofbirth[2];
        if ($birthMonth == 0 || $birthMonth >12 || $birthDay == 0 || $birthDay > 31
            || $birthYear < 1970) {          
            $isValid = false;
        }
        $today = date("d-m-Y"); 
        $age = strtotime($today) - strtotime($dob);
        if ($age < 0) {
            $isValid = false;
        }
        return $isValid;
    }

    /**
     * To persist the user into the database
     * 
     * @param type $all_rows
     */
    public function saveUser($all_rows)
    {
        $msg = array("success", true);
        $em = $this->getDoctrine()->getManager();
        $bloodrepo = $em->getRepository('UserManagementBundle:BloodGroup');
        $bloodArray = $bloodrepo->findAll();
        $genderrepo = $em->getRepository('UserManagementBundle:Gender');
        $genderArray = $genderrepo->findAll();
        $interestrepo = $em->getRepository('UserManagementBundle:Interest');
        $interestArray = $interestrepo->findAll();
        $educationrepo = $em->getRepository('UserManagementBundle:EducationType');
        $edutypeArray = $educationrepo->findAll();
        
        foreach($all_rows as $row) {
            $userrepo = $em->getRepository('UserManagementBundle:User');
            $userProfile = $userrepo->findOneBy(array('username' => $row['username']));
            if (!$userProfile) {
                $userProfile = new User();
            }
            $blood = $userProfile->setCsvBlood($bloodArray, $row['blood']);
            $gender = $userProfile->setCsvGender($genderArray, $row['gender']);

            $interests = explode(',', $row['interests']);
            $isValidInterest = $userProfile->setCsvInterest($interestArray, $interests);
            if (!$isValidInterest) {
                $message = "Please provide valid interest for the user: ".$row['username'];
                $msg = array($message, false);
                return $msg;
            }
            
            $educations = explode(',', $row['education']);
            $isValidEdutype = $userProfile->setCsvEducation($edutypeArray, $educations);
            if (!$isValidEdutype) {
                $message = "Please provide valid edu type for the user: ".$row['username'];
                $msg = array($message, false);
                return $msg;
            }
            
            $emails = explode(',', $row['emails']);
            $userProfile->setCsvEmail($emails);
            
            $mobileNumbers = explode(',', $row['mobileNumbers']);
            $userProfile->setCsvPhone($mobileNumbers);
            
            if ($row['dob'] == "") {
                $message = "dateofbirth should not be empty for the user: ".$row['username'];
                $msg = array($message, false);
                return $msg;
            } else {
                if (!$this->validateDob($row['dob'])) {
                    $message = "Provide valid dateofbirth for the user: ".$row['username'];
                    $msg = array($message, false);
                    return $msg;
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
            $validator = $this->get('validator');
            $errors = $validator->validate($userProfile);
            
            if (count($errors) > 0) {
                $errorString = "";
                foreach ($errors as $i => $error) {
                    $errorString .= $error->getMessage()."\n";
                }
                $message = $row['username'] . "=>" .$errorString;
                $msg = array($message, false);
                return $msg;
            }
            $em->persist($userProfile);
            $em->flush();
        }
        return $msg;
    }

    public function csvExportAction()
    {
        $response = new StreamedResponse();
        $response->setCallback(function() {
            $handle = fopen('php://output', 'w+');
            $csvArray = array();
            fputcsv($handle, array(
                'username', 'firstname', 'lastname', 'gender', 'bloodgroup',
                'dob', 'emails', 'mobilenumbers', 'interests', 'education')
            );
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository('UserManagementBundle:User');
            $results = $repo->findAll();
            foreach ($results as $result) {
                $data['username'] = $result->getUserName();
                $data['firstname'] = $result->getFirstName();
                $data['lastname'] = $result->getLastName();
                $data['gender'] = $result->getGender();
                $data['bloodgroup'] = $result->getBlood();
                $data['dob'] = date_format($result->getDob(), 'd-m-Y');
                $emails = $result->getEmails();
                $i = 0;
                foreach ($emails as $emailid) {
                    $email[$i] = $emailid->getEmailAddr();
                    $i++;
                }
                $data['emails'] = implode(',', $email);
                $mobileNumbers = $result->getMobileNumbers();
                $i = 0;
                foreach ($mobileNumbers as $mobilenumber) {
                    $number[$i] = $mobilenumber->getNumber();
                    $i++;
                }
                $data['mobilenumbers'] = implode(',', $number);
                $interests = $result->getInterests();
                $i = 0;
                foreach ($interests as $interest) {
                    $interestArea[$i] = $interest->getInterest();
                    $i++;
                }
                $data['interests'] = implode(',', $interestArea);
                $educationList = $result->getEducation();
                $i = 0;
                foreach ($educationList as $education) {
                    $educations[$i] = $education->getEduType()."-".$education->getInstitute();
                    $i++;
                }
                $data['education'] = implode(',', $educations);
                $csvArray[] = $data;
             }
            foreach ($csvArray as $csvSingle) {
                fputcsv($handle,$csvSingle);
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
