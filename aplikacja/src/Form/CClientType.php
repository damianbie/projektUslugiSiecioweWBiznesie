<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['row_attr'=>['class'=>'form-group'], 'attr' => ['class'=>'form-control']])
            ->add('nip', TextType::class, ['row_attr'=>['class'=>'form-group'], 'attr' => ['class'=>'form-control']])
            ->add('regon', TextType::class, ['row_attr'=>['class'=>'form-group'], 'attr' => ['class'=>'form-control']])
            ->add('phoneNumber', TextType::class, ['row_attr'=>['class'=>'form-group'], 'attr' => ['class'=>'form-control']])
            ->add('address', AddressType::class, ['mapped' => false])
            ->add('submit', SubmitType::class, ['label' => 'Dodaj do bazy','row_attr'=>['class'=>'form-group'], 'attr' => ['class'=>'btn btn-primary float-right']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class
        ]);
    }
}
