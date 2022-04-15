<?php

namespace App\Controller;

use App\Entity\Suites;
use App\Entity\Clients;
use App\Entity\Etablissements;
use App\Entity\Reservations;
use App\Repository\ResaRepo;
use App\Form\ResaFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

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
