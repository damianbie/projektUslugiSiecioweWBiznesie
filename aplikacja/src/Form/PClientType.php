<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Imie', 'row_attr'=>['class'=>'form-group'], 'attr' => ['class'=>'form-control']])
            ->add('surname', TextType::class, ['label' => 'Nazwisko', 'row_attr'=>['class'=>'form-group'], 'attr' => ['class'=>'form-control']])
            ->add('pesel', TextType::class, ['label' => 'Pesel', 'row_attr'=>['class'=>'form-group'], 'attr' => ['class'=>'form-control']])
            ->add('phoneNumber', TextType::class, ['label' => 'Numer telefonu', 'row_attr'=>['class'=>'form-group'], 'attr' => ['class'=>'form-control']])
            ->add('address', AddressType::class, ['label' => 'adres', 'mapped' => false])
            ->add('submit', SubmitType::class, ['label' => 'Zapisz','row_attr'=>['class'=>'form-group'], 'attr' => ['class'=>'btn btn-primary float-right']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
