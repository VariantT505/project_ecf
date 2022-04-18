<?php

namespace App\Controller\Admin;

use App\Entity\Etablissements;
use App\Entity\Suites;
use App\Repository\EtablRepo;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SuitesCrudController extends AbstractCrudController
{
    public const SUITE_BASE_PATH = '/images/suites';
    public const SUITE_UPLOAD_DIR = 'public/images/suites';


    public static function getEntityFqcn(): string
    {
        return Suites::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $user = $this->getUser()->getEtaid();
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $qb->where('entity.etaid = :id');
        $qb->setParameter('id', $user);

        return $qb;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Nom de la suite'),
            ImageField::new('featuredimage', 'Photo principale')
            ->setBasePath(self::SUITE_BASE_PATH)
            ->setUploadDir(self::SUITE_UPLOAD_DIR),
            TextareaField::new('description', 'Description')->hideOnIndex(),
            IntegerField::new('price', 'Tarif/nuit'),
            ImageField::new('galleryone', 'Illustration 1')->hideOnIndex()
            ->setBasePath(self::SUITE_BASE_PATH)
            ->setUploadDir(self::SUITE_UPLOAD_DIR),
            ImageField::new('gallerytwo', 'Illustration 2')->hideOnIndex()
            ->setBasePath(self::SUITE_BASE_PATH)
            ->setUploadDir(self::SUITE_UPLOAD_DIR),
            ImageField::new('gallerythree', 'Illustration 3')->hideOnIndex()
            ->setBasePath(self::SUITE_BASE_PATH)
            ->setUploadDir(self::SUITE_UPLOAD_DIR),
            TextField::new('bookingurl', 'Lien Booking.com'),
            AssociationField::new('etaid', 'Nom de l\'établissement')
            ->hideOnIndex(),
            // ->autocomplete(),
            // AssociationField::new('etaid', 'Nom de l\'établissement')->setQueryBuilder(
            //     fn (QueryBuilder $queryBuilder) => $queryBuilder->getEntityManager()->getRepository(Etablissements::class)->findByEtaid()
            // )
            // ->hideOnIndex(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Suite')
            ->setEntityLabelInPlural('Suites')
            ->setSearchFields(['suiid', 'title']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions

        ->setPermission(Action::NEW, 'ROLE_GERANT')
        ->setPermission(Action::DELETE, 'ROLE_GERANT')
        ->setPermission(Action::EDIT, 'ROLE_GERANT')
        ->setPermission(Action::INDEX, 'ROLE_GERANT')
    ;
    }
}
