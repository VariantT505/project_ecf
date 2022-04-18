<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Etablissements;
use App\Repository\EtablRepo;
use App\Repository\SuitesRepo;

class FooterController extends AbstractController
{
    public function etablissementAction(EtablRepo $etablRepo): Response
    {
        $etablissements = $etablRepo->findAll();

        return $this->render('footer.html.twig', [
            'controller_name' => 'FooterController',
            'etablissements' => $etablissements,
        ]);
    }

    #[Route('/etablissement/{id}', name: 'etab_list', methods: ['GET'])]
    public function showAction(Etablissements $etablissements, SuitesRepo $suitesRepo): Response
    {
        $id =  $etablissements->getEtaid();

        $suites = $suitesRepo->findByetaid($id);


        return $this->render('etablissement/listing.html.twig', [
            'etablissement' => $etablissements,
            'suites' => $suites,
        ]);
    }

}
