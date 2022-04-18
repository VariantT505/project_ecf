<?php

namespace App\Controller;

use App\Entity\Suites;
use App\Entity\Reservations;
use App\Entity\Clients;
use App\Form\ReservationType;
use App\Repository\ResaRepo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ReservationController extends AbstractController
{
    public RequestStack $requestStack;
    public EntityManagerInterface $entityManager;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager){
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }

    #[Route('/compte', name: 'app_resa', methods: ['GET'])]
    public function show(#[CurrentUser] ?Clients $user, ResaRepo $resaRepo): Response
    {
        $user = $this->getUser();
        $reservations = $resaRepo->findby(['cliid' => $user]);

        return $this->render('reservations/compte.html.twig', [
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

    #[Route(path: '/{etaid}/{suiid}', name: 'app_reservation', methods: ['GET', 'POST'])]
    public function new(#[CurrentUser] ?Clients $user, Request $request, ResaRepo $resaRepo, Suites $suites, $suiid): Response
    {
        if ($_GET == true) {
            $suite = $_GET['suite'];
            $etablissement = $_GET['etablissement'];
            $this->requestStack->getSession()->set('etablissement', $etablissement);
            $this->requestStack->getSession()->set('suite', $suite);
        }

        $user = $this->getUser();
        $suites->getSuiid($suiid);
        $etablissement = $suites->getEtaid();

        $reservations = new Reservations();
        $reservations->setEtaid($etablissement);
        $reservations->setSuiid($suites);
        $formAjax = $this->createForm(ReservationType::class, $reservations);
        $formAjax->handleRequest($request);
        $data = null;
        $reservationExisting = "";
        if ($formAjax->isSubmitted() && $formAjax->isValid()) {

                /** @var  Clients $users */
                $users = $this->getUser();

                $filter = $resaRepo->findExistingReservation(
                    $formAjax->get('etaid')->getData(),
                    $formAjax->get('suiid')->getData(),
                    $formAjax->get('startdate')->getData(),
                    $formAjax->get('enddate')->getData()
                );

                $reservations->setCliid($users);

                if (empty($filter)){
                   $data = $formAjax->getData();
                   $this->requestStack->getSession()->set('reservation', $data);
                }

                if (!empty($filter)){
                    $reservationExisting = null;
                };
    }

        return $this->render('reservations/index.html.twig', [
            'controller_name' => 'ReservationController',
            'form' => $formAjax->createView(),
            'data' => $data,
            'reservation' => $reservations,
            'reservationExisting' => $reservationExisting,
            'etaid' => $etablissement->getEtaid(),
            'suiid' => $suites->getSuiid(),
        ]);
    }

    #[Route('/confirmation', name: 'app_reservation_confirm')]
    public function confirm(): Response
    {
        if ($this->requestStack->getSession()->get('reservation')){
            $reservation = new Reservations();
            $data = $this->requestStack->getSession()->get('reservation');
            $reservation->setStartdate($data->getStartdate());
            $reservation->setEnddate($data->getEnddate());
            $reservation->setEtaid($data->getEtaid());
            $reservation->setSuiid($data->getSuiid());
            $reservation->setCliid($data->getCliid());

            $this->entityManager->merge($reservation);
            $this->entityManager->flush();
            $this->requestStack->getSession()->remove('reservation');
        }
        else{
            return $this->redirectToRoute('app_resa');
        };

        return $this->redirectToRoute('app_resa');
    }
}