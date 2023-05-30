<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/app/login', name: 'app_login')]
    public function index(AuthenticationUtils $auth): Response
    {
        return $this->render('login/index.html.twig');
    }

    public function loginForm(AuthenticationUtils $auth): Response
    {
        $error = $auth->getLastAuthenticationError();

        $lastUsername = $auth->getLastUsername();

        return $this->render('login/_form.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/app/logout', name: 'app_logout')]
    public function logout()
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml!');
    }
}
