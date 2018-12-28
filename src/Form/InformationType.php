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
                'label' => 'Prénom',
                'invalid_message' => 'Le prénom n\'est pas valide'
            ))
            ->add('lastname', TextType::class, array(
                'invalid_message' => 'Le nom n\'est pas valide',
                'label' => 'Nom'
            ))
            ->add('birthdate', DateType::class, array(
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'invalid_message' => 'La date est invalide',
                'html5' => false,
                'format' => 'dd-MM-yyyy',
                'attr' => array(
                    'readonly' => true,
                    'class' => 'information_birthdate')
            ))
            ->add('country', CountryType::class, array(
                'label' => 'Pays',
                'invalid_message' => 'Le pays n\'est pas valide',
                "preferred_choices" => array(
                    'FR')
            ))
            ->add('reducedprice', CheckboxType::class, array(
                'label' => ('Tarif réduit (Un justicatif devra être présenté lors de l’entrée)'),
                'required' => false,
                'invalid_message' => 'La valeur du tarif réduit comporte une erreur',
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
