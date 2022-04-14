<?php

namespace App\Controller\Admin;

use App\Entity\Clients;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;

class ClientsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Clients::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $user = $this->getUser()->getCliid();
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $qb->where('entity.cliid = :id');
        $qb->setParameter('id', $user);

        return $qb;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Client')
            ->setEntityLabelInPlural('Clients')
            ->setSearchFields(['cliid', 'email']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstname', 'Prénom'),
            TextField::new('lastname', 'Nom'),
            EmailField::new('email'),
            TextField::new('password', 'Mot de passe')->hideOnIndex(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions

        ->remove(Crud::PAGE_INDEX, Action::NEW)
    ;
    }
}
