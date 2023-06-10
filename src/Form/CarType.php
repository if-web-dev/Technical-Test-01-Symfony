<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\CarCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('nbDoors', ChoiceType::class, [
                'label' => 'Number of doors',
                'choices'  => [
                    '3' => 3,
                    '5' => 5,
                ],
            ])
            ->add('nbSeats', ChoiceType::class, [
                'label' => 'Number of seats',
                'choices'  => [
                    '2' => 3,
                    '5' => 5,
                    '7' => 7,
                ],
            ])
            ->add('cost')
            ->add('carCategory', EntityType::class, [
                'label' => 'Category',
                'class' => carCategory::class,
                'choice_label' => 'name',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save this car',
                'attr' => [
                    'class' => 'btn btn-outline-success text-uppercase d-block btn-lg mx-auto mt-5',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
