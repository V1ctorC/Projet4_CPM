<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bookingday', DateType::class, array(
                'label' => 'Date souhaitée',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd-MM-yyyy',
                'invalid_message' => 'La date est invalide',
                'attr' => array(
                    'data-type' => 'date',
                    'readonly' => true
                )
                ))
            ->add('type', ChoiceType::class, array(
                'label' => 'Type de billet',
                'invalid_message' => 'La type est invalide',
                'choices' => array(
                    '1 journée' => 'W',
                    '1/2 journée' => 'H',
                ),
                'expanded' => true,
                'required' => true,
            ))
            ->add('quantity', ChoiceType::class, array(
                'label' => 'Nombre de billets',
                'invalid_message' => 'La quantité est invalide',
                'choices' => array(
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                    '11' => 11,
                    '12' => 12,
                    '13' => 13,
                    '14' => 14,
                    '15' => 15
                )
            ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
