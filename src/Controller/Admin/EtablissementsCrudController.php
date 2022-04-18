<?php

namespace App\Controller\Admin;

use App\Entity\Etablissements;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EtablissementsCrudController extends AbstractCrudController
{
    public const ETAB_BASE_PATH = '/images/etablissements';
    public const ETAB_UPLOAD_DIR = 'public/images/etablissements';

    public static function getEntityFqcn(): string
    {
        return Etablissements::class;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->updatePassword($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }
    
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->updatePassword($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }
    
    private function updatePassword(Etablissements $user): void
    {
        if ($user->getPlainPassword() == '') return;
        $this->userRepository->setNewPassword($user, $user->getPlainPassword());
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
            ->setEntityLabelInPlural('Etablissements')
            ->setSearchFields(['etaid', 'email']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Etablissement'),
            TextField::new('address', 'Adresse'),
            IntegerField::new('postalcode', 'Code postal'),
            TextField::new('city', 'Ville'),
            TextField::new('gerantfirstname', 'Prénom Gérant'),
            TextField::new('gerantname', 'Nom Gérant'),
            TextareaField::new('description', 'Description')->hideOnIndex(),
            EmailField::new('email'),
            ImageField::new('featuredimage', 'Photo')
            ->setBasePath(self::ETAB_BASE_PATH)
            ->setUploadDir(self::ETAB_UPLOAD_DIR),
            TextField::new('password', 'Mot de passe')->hideOnIndex(),
            AssociationField::new('admid', 'Email de l\'Administrateur')
            ->hideOnIndex()
            ->autocomplete(),
        ];
    }
}
