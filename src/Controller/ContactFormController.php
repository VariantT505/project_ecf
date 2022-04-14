<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactFormController extends AbstractController
{
    #[Route('/contact', name: 'app_contact_form')]
    public function contact(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();

            $email = (new Email())
                ->from('contact@hypnos.fr')
                ->to('admin@hypnos.fr')
                ->subject('Nouveau contact sur votre site')
                ->text(
                    'Nom : '.$contactFormData['name'].\PHP_EOL.
                    'Prenom : ' .$contactFormData['firstName'].\PHP_EOL.
                    'Email : ' .$contactFormData['email'].\PHP_EOL.
                    'Sujet : ' .$contactFormData['subject'].\PHP_EOL.
                    'Message : ' .$contactFormData['message']
                );

            $mailer->send($email);

            $this->addFlash(
                'success',
                'Votre message a été envoyé'
            );

            return $this->redirectToRoute('app_contact_form');
        }

        return $this->render('contact_form/contact.html.twig', [
            'contactform' => $form->createView()
        ]);
    }
}
