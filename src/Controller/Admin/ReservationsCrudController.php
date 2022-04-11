<?php

namespace App\Controller\Admin;

use App\Entity\Reservations;
use App\Entity\Suites;
use App\Repository\SuitesRepo;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ReservationsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservations::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $user = $this->getUser()->getCliid();
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $qb->where('entity.cliid = :id');
        $qb->setParameter('id', $user);

        return $qb;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('suiid', 'Suite'),
            DateField::new('startdate', 'Date d\'arrivée')->setFormat('dd/MM/yyyy'),
            DateField::new('enddate', 'Date de départ')->setFormat('dd/MM/yyyy'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions

        ->remove(Crud::PAGE_INDEX, Action::NEW)
        ->remove(Crud::PAGE_INDEX, Action::EDIT)
        ->remove(Crud::PAGE_DETAIL, Action::EDIT)
    ;
    }
}
