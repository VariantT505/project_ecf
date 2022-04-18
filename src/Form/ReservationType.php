<?php

namespace App\Form;

use App\Entity\Suites;
use App\Entity\Etablissements;
use App\Entity\Reservations;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public RequestStack $requestStack;

    public  function __construct(RequestStack $requestStack){
        $this->requestStack = $requestStack;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etaid', EntityType::class, [
                'class' => Etablissements::class,
                'choice_label' => function ($etablissements) {
                  return  $etablissements->getName() . ' - ' . $etablissements->getCity();
                },
                'label' => "Etablissement : ",
                'mapped' => true,
                'disabled' => true,
                'attr' => [
                  'class' => 'form-control'
              ],
                ])
              ->add('suiid', EntityType::class, [
                'class' => Suites::class,
                'choice_label' => function ($suites) {
                  return  $suites->getTitle() . ' - ' . $suites->getPrice() . '€/nuit';
                },
                'label' => "Suite : ",
                'mapped' => true,
                'disabled' => true,
                'attr' => [
                  'class' => 'form-control'
              ],
              ])
              ->add('startdate', DateType::class, [
                'required' => true,
                'widget' => 'single_text',
                'label' => 'Date d\'arrivée : ',
                'format' => 'yyyy-MM-dd',
              ])
              ->add('enddate', DateType::class, [
                'required' => true,
                'widget' => 'single_text',
                'label' => 'Date de départ : ',
                'format' => 'yyyy-MM-dd',
              ])
            ->add('Rechercher', SubmitType::class,[
                'label' => "Vérifier la disponibilité",
                'attr' => ['class' => 'btn btn-outline-secondary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}