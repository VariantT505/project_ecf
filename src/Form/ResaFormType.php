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

      ->add('etaid', EntityType::class, [
        'class' => Etablissements::class,
        'choice_label' => function ($etablissements) {
          return  $etablissements->getName() . ' - ' . $etablissements->getCity();
        },
        'label' => "Etablissement souhaité : ",
        'mapped' => true,
      ])
      ->add('suiid', EntityType::class, [
        'class' => Suites::class,
        'choice_label' => function ($suites) {
          return  $suites->getTitle() . ' - ' . $suites->getPrice() . '€/nuit';
        },
        'label' => "Suite souhaitée : ",
        'mapped' => true,
        'disabled' => true,
      ])
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
      ]);

    // $formModifier = function (FormInterface $form, Etablissements $etablissement = null) {
    //   $suite = null === $etablissement ? [] : $etablissement->getSuiid();

    //   $form->add('suite', EntityType::class, [
    //     'class' => Suites::class,
    //     'choice_label' => 'title',
    //     'choices' => $suite,
    //     'placeholder' => '- Choisir une suite -',
    //     'label' => 'Suites : '
    //   ]);
    // };

    $builder->addEventListener(
      FormEvents::PRE_SET_DATA,
      function (FormEvent $event) use ($SuitesRepo){
        $data = $event->getData()['Etaid'];
        $formModifier($event->getForm(), $data->getEtaid());
      }
    );

    $builder->get('etaid')->addEventListener(
      FormEvents::POST_SUBMIT,
      function (FormEvent $event) use ($formModifier) {
        // It's important here to fetch $event->getForm()->getData(), as
        // $event->getData() will get you the client data (that is, the ID)
        $etaid = $event->getForm()->getData();


        // since we've added the listener to the child, we'll have to pass on
        // the parent to the callback functions!
        $formModifier($event->getForm()->getParent(), $etaid);
      }
    );
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Reservations::class,
    ]);
  }
}
