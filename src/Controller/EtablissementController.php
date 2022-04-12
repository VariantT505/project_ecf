<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Suites;
use App\Repository\ResaRepo;
use Symfony\Component\HttpFoundation\Request;

class EtablissementController extends AbstractController
{
    #[Route('/etablissement', name: 'app_etablissement')]
    public function index(): Response
    {
        return $this->render('etablissement/listing.html.twig', [
            'controller_name' => 'EtablissementController',
        ]);
    }

    #[Route('/suite/{id}', name: 'app_suite_show', methods: ['GET'])]
    public function showSuite(Suites $suites): Response
    {
        return $this->render('suite/show.html.twig', [
            'suite' => $suites,
        ]);
    }
    /**
     * @Route("/{id}/new", name="app_reservation_new_r", methods= {"GET", "POST"})
     */
    public function newR(Request $request, ResaRepo $resaRepo, $id, Suites $suites): Response
    {

        $user = $this->getUser();


        $suites->getSuiid($id);
        $etablissement = $suites->getEtaid();
        $result = $resaRepo->findByHotelId($etablissement);

        $r = count($result);

        if ($r < 1) {
            $reservation = new Reservation();
            $reservation->setHotel($etablissement);
            $reservation->setSuite($suites);
            $form = $this->createForm(ReservationType::class, $reservation);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $reservation->setUser($user);
                $resaRepo->add($reservation);

                return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('reservation/new.html.twig', [
                'reservation' => $reservation,
                'form' => $form,
            ]);
        } else {
            return $this->redirectToRoute('app_reservation_new', [], Response::HTTP_SEE_OTHER);
        }

    }
}