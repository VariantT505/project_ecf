<?php

namespace App\Controller\Admin;

use App\Entity\Administrateurs;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdministrateursCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Administrateurs::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
