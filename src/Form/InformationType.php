<?php

namespace App\Form;

use App\Entity\Information;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array(
                'label' => 'Prénom'
            ))
            ->add('lastname', TextType::class, array(
                'label' => 'Nom'
            ))
            ->add('birthdate', DateType::class, array(
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'attr' => array(
                    'readonly' => true,
                    'class' => 'information_birthdate')
            ))
            ->add('country', CountryType::class, array(
                'label' => 'Pays',
                "preferred_choices" => array(
                    'FR')
            ))
            ->add('reducedprice', CheckboxType::class, array(
                'label' => ('Tarif réduit (Un justicatif devra être présenté lors de l’entrée)'),
                'required' => false,
                'attr' => array(
                    'class' => 'information_reduced',
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Information::class,
        ]);
    }
}
