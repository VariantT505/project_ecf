<?php

namespace App\Form;

use App\Entity\Etablissements;
use App\Entity\Reservations;
use App\Entity\Suites;
use App\Repository\SuitesRepo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResaFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('startDate', DateType::class, [
                'required' => true,
                'widget' => 'single_text',
                'label' => 'Date d\'arrivée : ',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('endDate', DateType::class, [
                'required' => true,
                'widget' => 'single_text',
                'label' => 'Date de départ : ',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('etaid', EntityType::class, [
                'class' => 'App\Entity\Etablissements',
                'choice_label' => 'name',
                'label' => 'Hotel : ',
                'placeholder' => '- Choisir un établissement -',
            ]);

    //         $formModifier = function (FormInterface $form, Etablissements $etablissements = null) {
    //             $suites = null === $etablissements ? [] : $etablissements->getAvailableSuite();

    //         $form->add('suiid',EntityType::class, [
    //                 'class' => 'App\Entity\Suites',
    //                 'choice_label' => 'title',
    //                 'choices' => $suites,
    //                 'placeholder' => '- Choisir une suite -',
    //                 'label' => 'Suites : ',
    //                 'disabled' => $etablissements === null
    //             ]);
    // };

        // $builder->addEventListener(
        //     FormEvents::PRE_SET_DATA,
        //     function (FormEvent $event) use ($formModifier) {
        // //         // this would be your entity, i.e. SportMeetup
        //         $data = $event->getData();
        //         $formModifier($event->getForm(), $data->getsuiid());
        //     }
        // );

        $builder->get('etaid')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
              $form = $event->getForm();
              $this->addSuites($form->getParent(), $form->getData());
            }
          );
        }

          private function addSuites(FormInterface $form, ?Etablissements $etablissements)
{
  $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
    'suiid',
    EntityType::class,
    null,
    [
      'class'           => 'AppBundle\Entity\Suites',
      'placeholder'     => $etablissements ? 'Sélectionnez votre département' : 'Sélectionnez votre région',
      'mapped'          => false,
      'required'        => false,
      'auto_initialize' => false,
      'choices'         => $etablissements ? $etablissements->getsuiid() : []
    ]
  );

        // $builder->get('etaid')->addEventListener(
        //     FormEvents::POST_SUBMIT,
        //     function (FormEvent $event) use ($formModifier) {
        //         $etablissements = $event->getForm()->getData();
        //         $formModifier($event->getForm()->getParent(), $etablissements);
        //     }
        // );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }

}