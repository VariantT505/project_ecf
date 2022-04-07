<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Administrateurs;
use App\Entity\Etablissements;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator->setController(AdministrateursCrudController::class)
            ->generateUrl();

        return $this->redirect($url);

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ecf Hypnos');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Dashboard');
        yield MenuItem::subMenu('Administrateurs', 'fas fa-bars')->setSubItems([
            MenuItem::linktoCrud('Afficher', 'fas fa-eye', Administrateurs::class),
            MenuItem::linktoCrud('Ajouter', 'fas fa-plus', Administrateurs::class)->setAction(Crud::PAGE_NEW),
        ]);
        yield MenuItem::subMenu('Gérants et établissements', 'fas fa-bars')->setSubItems([
            MenuItem::linktoCrud('Afficher', 'fas fa-eye', Etablissements::class),
            MenuItem::linktoCrud('Ajouter', 'fas fa-plus', Etablissements::class)->setAction(Crud::PAGE_NEW),
        ]);
    }
}
