<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route(path: '/register', name: 'app_register')]
    public function register(): Response
    {
        return $this->render(view: 'registration/register.html.twig');
    }
}
