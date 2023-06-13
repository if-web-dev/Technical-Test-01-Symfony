<?php

namespace App\Form;

use App\Model\SearchData;
use App\Entity\CarCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control rounded',
                    'placeholder' => 'Search a car',
                ]
            ])
            ->add('carCategory', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => CarCategory::class,
                'placeholder' => 'Select a car category',
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control rounded w-100',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
