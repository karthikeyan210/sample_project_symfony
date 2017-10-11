<?php
namespace UserManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use UserManagementBundle\Form\LoginType;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();
        
//        $form = $this->createForm(LoginType::class, array(
//            '_username' => $lastUsername,
//            'action' => $this->generateUrl('login'),
//            'method' => 'POST',
//        ));
        return $this->render('UserManagementBundle:security:login.html.twig', array(
//            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }
}