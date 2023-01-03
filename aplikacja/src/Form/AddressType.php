<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('country', CountryType::class, ['preferred_choices' => ['PL'],'label' => 'Kraj', 'attr' => ['class' => 'form-control select2', 'style'=>'width:100%;'], 'row_attr'=>['class' => 'form-group']])
            ->add('province', TextType::class, ['label' => 'Wojewódzctwo', 'attr' => ['class' => 'form-control'], 'row_attr'=>['class' => 'form-group']])
            ->add('town', TextType::class, ['label' => 'Miasto', 'attr' => ['class' => 'form-control'], 'row_attr'=>['class' => 'form-group']])
            ->add('street', TextType::class, ['label' => 'Ulica', 'attr' => ['class' => 'form-control'], 'row_attr'=>['class' => 'form-group']])
            ->add('postCode', TextType::class, ['label' => 'Kod pocztowy', 'attr' => ['class' => 'form-control postalCode'], 'row_attr'=>['class' => 'form-group']])
            ->add('houseNumber', TextType::class, ['label' => 'Numer budynku', 'attr' => ['class' => 'form-control'], 'row_attr'=>['class' => 'form-group']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
            'auto_initialize' => false,
        ]);
    }
}
