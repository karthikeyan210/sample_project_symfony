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
        
        $form = $this->createForm(LoginType::class, array(
            'username' => $lastUsername,
        ));
        return $this->render('UserManagementBundle:security:login.html.twig', array(
            'form' => $form->createView(),
            'error' => $error,
        ));
    }
}