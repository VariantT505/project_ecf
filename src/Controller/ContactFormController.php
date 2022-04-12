<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactFormController extends AbstractController
{
    #[Route('/contact', name: 'app_contact_form')]
    public function index(): Response
    {
        return $this->render('contact_form/contact.html.twig', [
            'controller_name' => 'ContactFormController',
        ]);
    }
}
