<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    public function __construct(UserPasswordHasherInterface $passwordHasher)
{
    $this->passwordHasher = $passwordHasher;
}

    #[Route(path: '/register', name: 'app_register')]
    public function register(Request $request, ManagerRegistry $doctrine): Response
    {
        $client = new Clients();
        $form = $this->createForm(RegistrationType::class, $client);
        $form->handleRequest($request);

if($form->isSubmitted() && $form->isValid()) {
    dd($form->getData());
    // $em = $doctrine->getManager();
    // $em->persist($client);
    // $em->flush();
}

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
