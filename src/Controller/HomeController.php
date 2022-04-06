<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Etablissements;
use App\Entity\Suites;
use App\Repository\EtablRepo;
use App\Repository\SuitesRepo;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/', name: 'app_home')]
    public function etablissement(EtablRepo $etablRepo): Response
    {
        $etablissements = $etablRepo->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'etablissements' => $etablissements,
        ]);
    }

    #[Route('/etablissement/{id}', name: 'etab_list', methods: ['GET'])]
    public function show(Etablissements $etablissements, SuitesRepo $suitesRepo): Response
    {
        $id =  $etablissements->getEtaid();

        $suites = $suitesRepo->findByetaid($id);


        return $this->render('etablissement/listing.html.twig', [
            'etablissement' => $etablissements,
            'suites' => $suites,
        ]);
    }
}
