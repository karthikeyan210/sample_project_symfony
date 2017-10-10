<?php

namespace UserManagementBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    protected $router;
    protected $session;

    public function __construct(Router $router, Session $session)
    {
        $this->router = $router;
        $this->session = $session;
    }
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        $this->session->getFlashBag()->add('denied', 'You dont have permission to access admin page!!');
        $route = $this->router->generate('user_management_list');
        return new RedirectResponse($route);
    }
}
