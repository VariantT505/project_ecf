<?php

namespace App\Controller\Admin;

use App\Entity\Etablissements;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EtablissementsCrudController extends AbstractCrudController
{
    public const ETAB_BASE_PATH = '/';
    public const ETAB_UPLOAD_DIR = 'public/images/etablissements';

    public static function getEntityFqcn(): string
    {
        return Etablissements::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
            return $qb;
        }
        else {
            $user = $this->getUser()->getEtaid();
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $qb->where('entity.etaid = :id');
        $qb->setParameter('id', $user);
        return $qb;    }

    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions

        ->setPermission(Action::NEW, 'ROLE_ADMIN')
        ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Etablissement')
            ->setEntityLabelInPlural('Etablissements');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Etablissement'),
            TextField::new('address', 'Adresse'),
            IntegerField::new('postalcode', 'Code postal'),
            TextField::new('city', 'Ville'),
            TextareaField::new('description', 'Description')->hideOnIndex(),
            EmailField::new('email'),
            ImageField::new('featuredimage', 'Photo')
            ->setBasePath(self::ETAB_BASE_PATH)
            ->setUploadDir(self::ETAB_UPLOAD_DIR),
            TextField::new('password', 'Mot de passe')->hideOnIndex(),
        ];
    }
}
