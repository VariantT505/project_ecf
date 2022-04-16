<?php

namespace App\Controller;

use App\Entity\Suites;
use App\Entity\Clients;
use App\Form\ResaFormType;
use App\Entity\Reservations;
use App\Repository\ResaRepo;
use App\Repository\EtablRepo;
use App\Entity\Etablissements;
use App\Repository\SuitesRepo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Contracts\EventDispatcher\Event;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_resa', methods: ['GET'])]
    public function show(#[CurrentUser] ?Clients $user, ResaRepo $resaRepo): Response
    {
        $user = $this->getUser();
        $reservations = $resaRepo->findby(['cliid' => $user]);

        return $this->render('reservations/index.html.twig', [
            'reservations' => $reservations
        ]);
    }

    #[Route(path: '/{id}', name: 'app_resa_del', methods: ['POST'])]
    public function delete(Request $request, Reservations $reservations, ResaRepo $resaRepo): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservations->getResid(), $request->request->get('_token'))) {
            $resaRepo->remove($reservations);
        }

        return $this->redirectToRoute('app_resa', [], Response::HTTP_SEE_OTHER);
    }

    #[Route(path: '/verif', name: 'app_resa_verif', methods: ['GET', 'POST'])]
    public function verif(ResaRepo $resaRepo): Response
    {
        if (!empty($_POST['suite']) && !empty($_POST['startDate']) && !empty($_POST['endDate'])) {
            $suite = $_POST['suite'];
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            $result = $resaRepo->disponible($suite, $startDate, $endDate);
            $r = count($result);
            if ($r < 1) {
                return $this->json([
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Suite disponible'
                ], 200);
            } else {
                return $this->json([
                    'code' => 200,
                    'status' => 'error',
                    'message' => 'Suite indisponible'
                ], 200);
            }
        } else {
            return $this->json([
                'code' => 200,
                'message' => 'Veuillez compléter les champs '
            ], 200);
        }
    }

    // #[Route(path: '/{etaid}/{suiid}', name: 'app_resa_new', methods: ['GET', 'POST'])]
    // public function new(#[CurrentUser] ?Clients $user, Request $request, ResaRepo $resaRepo, SuitesRepo $suitesRepo, EtablRepo $etablRepo, Suites $suites, $suiid): Response
    // {
    //     $user = $this->getUser();
    //     $suites->getSuiid($suiid);
    //     $etablissement = $suites->getEtaid();

    //     $reservations = new Reservations();
    //     $reservations->setEtaid($etablissement);
    //     $reservations->setSuiid($suites);

    //     $form = $this->createFormBuilder(Etablissements::class)
    //     ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($suitesRepo) {
    //         $etablissements = $event->getData('etaid') ?? null;
    //         $suite = $etablissements === null ? [] : $suitesRepo->createQueryBuilder('s')
    //         ->andWhere('s.etaid = :etablissements')
    //         ->setParameter('etablissements', $etablissements)
    //         ->getQuery()
    //         ->getResult();
    //         $event->getForm()->add('suiid', EntityType::class, [
    //             'class' => Suites::class,
    //             'choice_label' => function ($suite) {
    //               return  $suite->getTitle() . ' - ' . $suite->getPrice() . '€/nuit';
    //             },
    //             'label' => "Suite souhaitée : ",
    //             'mapped' => true,
    //           ]);
    //     })
    //     ->add('etaid', EntityType::class, [
    //         'class' => Etablissements::class,
    //         'choice_label' => function ($etablissements) {
    //           return  $etablissements->getName() . ' - ' . $etablissements->getCity();
    //         },
    //         'label' => "Etablissement souhaité : ",
    //         'mapped' => true,
    //       ])
    //     //   ->add('suiid', EntityType::class, [
    //     //     'class' => Suites::class,
    //     //     'choice_label' => function ($suites) {
    //     //       return  $suites->getTitle() . ' - ' . $suites->getPrice() . '€/nuit';
    //     //     },
    //     //     'label' => "Suite souhaitée : ",
    //     //     'mapped' => true,
    //     //     'disabled' => true,
    //     //   ])
    //       ->add('startDate', DateType::class, [
    //         'required' => true,
    //         'widget' => 'single_text',
    //         'label' => 'Date d\'arrivée : ',
    //         'format' => 'yyyy-MM-dd',
    //       ])
    //       ->add('endDate', DateType::class, [
    //         'required' => true,
    //         'widget' => 'single_text',
    //         'label' => 'Date de départ : ',
    //         'format' => 'yyyy-MM-dd',
    //       ])
    //       ->getform();

    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $user = $this->getUser();
    //         $reservations->setCliid($user);
    //         $resaRepo->add($reservations);

    //         return $this->redirectToRoute('app_resa', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('reservations/ajout.html.twig', [
    //         'reservation' => $reservations,
    //         'form' => $form,
    //         'etaid' => $etablissement->getEtaid(),
    //         'suiid' => $suites->getSuiid(),
    //     ]);
    // }
    
    #[Route(path: '/{etaid}/{suiid}', name: 'app_resa_new', methods: ['GET', 'POST'])]
    public function new(#[CurrentUser] ?Clients $user, Request $request, ResaRepo $resaRepo, Suites $suites, $suiid): Response
    {
        $user = $this->getUser();
        $suites->getSuiid($suiid);
        $etablissement = $suites->getEtaid();

        $reservations = new Reservations();
        $reservations->setEtaid($etablissement);
        $reservations->setSuiid($suites);
        $form = $this->createForm(ResaFormType::class, $reservations);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $reservations->setCliid($user);
            $resaRepo->add($reservations);

            return $this->redirectToRoute('app_resa', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservations/ajout.html.twig', [
            'reservation' => $reservations,
            'form' => $form,
            'etaid' => $etablissement->getEtaid(),
            'suiid' => $suites->getSuiid(),
        ]);
    }

    // #[Route(path: '/{etaid}/{suiid}', name: 'app_resa_new', methods: ['GET', 'POST'])]
    // public function newR(#[CurrentUser] ?Clients $user, $suiid, Request $request, ResaRepo $resaRepo, Suites $suites, Etablissements $etablissements): Response
    // {
    //     $user = $this->getUser();
    //     $suites->getSuiid($suiid);
    //     $etablissement = $suites->getEtaid();
    //     $result = $resaRepo->findByEtaid($etablissement);
    //     $r = count($result);

    //     if ($r < 1) {
    //         $reservation = new Reservations();
    //         $reservation->setEtaid($etablissement);
    //         $reservation->setSuiid($suites);
    //         $form = $this->createForm(ResaFormType::class, $reservation);
    //         $form->handleRequest($request);

    //         if ($form->isSubmitted() && $form->isValid()) {
    //             $reservation->setCliid($user);
    //             $resaRepo->add($reservation);

    //             return $this->redirectToRoute('app_resa', [], Response::HTTP_SEE_OTHER);
    //         }

    //         return $this->renderForm('reservations/ajout.html.twig', [
    //             'reservation' => $reservation,
    //             'form' => $form,
    //         ]);
    //     } else {
    //         return $this->redirectToRoute('app_resa_new', [
    //             'etaid' => $etablissements->getEtaid(),
    //             'suiid' => $suites->getSuiid(),
    //         ], Response::HTTP_SEE_OTHER);
    //     }
    // }
}
