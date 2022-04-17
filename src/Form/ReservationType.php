<?php

namespace App\Form;

use App\Entity\Suites;
use App\Entity\Etablissements;
use App\Entity\Reservations;
use App\Repository\SuitesRepo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReservationType extends AbstractType
{
    public RequestStack $requestStack;

    public  function __construct(RequestStack $requestStack){
        $this->requestStack = $requestStack;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('startdate',  DateType::class, [
            //     'required' => true,
            //     'label' => "Date d'arrivée",
            //     'widget' => 'single_text',
            //     'empty_data' => null,
            //     'attr' => [
            //         "class" => 'start',
            //         "autocomplete" => 'off'
            //     ],
            // ])
            // ->add('enddate', DateType::class, [
            //     'label' => "Date de départ",
            //     'widget' => 'single_text',
            //     'empty_data' => null,
            //     'attr' => [
            //         "class" => 'end',
            //         "autocomplete" => 'off'
            //     ],
            // ])
            // ->add('etaid', EntityType::class, [
            //     'label' => "Choix de l'hôtel",
            //     'class' => Etablissements::class,
            //     'placeholder' => 'Choisir un hôtel',
            //     'choice_attr' => function($etablissement) {
            //         $session = $this->requestStack->getSession()->get('etaid');
            //         $attr = [];
            //         if ($etablissement->getEtaid() == $session){
            //             $attr['selected'] = 'selected';
            //         }
            //         return $attr;
            //     }
            // ])
            //     ->add('suiid', EntityType::class, [
            //         'label' => "Choix de l'hôtel",
            //         'class' => Suites::class,
            //         'placeholder' => 'Choisir un hôtel',
            //         'choice_attr' => function($suite) {
            //             $session = $this->requestStack->getSession()->get('suiid');
            //             $attr = [];
            //             if ($suite->getSuiid() == $session){
            //                 $attr['selected'] = 'selected';
            //             }
            //             return $attr;
            //         }
            //     ])
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

        // $formModifier = function (FormInterface $form, Etablissements $etablissements = null) {
        //         $suites = null === $etablissements ? [] : $etablissements->getSuiid();
        //         $etablissement = $this->requestStack->getSession()->get('etaid');
        //         $form->add('suiid', EntityType::class, [
        //             'class' => Suites::class,
        //             'label' => 'Choix de la suite',
        //             'query_builder' => function (SuitesRepo $repository) use ($suites, $etablissement){
        //                 if ($this->requestStack->getSession()->get('suiid')){
        //                     $render = $repository->createQueryBuilder('e')
        //                         ->andWhere('e.etaid = :etaid')
        //                         ->setParameter('etaid', $etablissement);
        //                 } else {
        //                     $render = $repository->createQueryBuilder('e')
        //                         ->andWhere('e.etaid = :etaid')
        //                         ->setParameter('etaid', $suites);
        //                 }
        //                 return $render;
        //             },
        //             'choice_attr' => function ($etablissement) {
        //                 $session = $this->requestStack->getSession()->get('suiid');
        //                 $attr = [];
        //                 if ($etablissement->getEtaid() == $session) {
        //                     $attr['selected'] = 'selected';
        //                 }
        //                 return $attr;
        //             }
        //         ]);
        //     };
        //     $builder->addEventListener(
        //     FormEvents::PRE_SET_DATA,
        //     function (FormEvent $event) use ($formModifier) {
        //         $data = $event->getData()->getSuiid();
        //         $formModifier($event->getForm(), $data);
        //     });

        //     $builder->get('etaid')->addEventListener(
        //         FormEvents::POST_SUBMIT,
        //         function (FormEvent $event) use ($formModifier){
        //             $this->requestStack->getSession()->set('suiid', "");
        //             $etablissement = $event->getForm()->getData();
        //             $formModifier($event->getForm()->getParent(), $etablissement);
        //         }
        //     );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}