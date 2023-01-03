<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Vehicle;
use App\Repository\ClientRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('manufacturer', TextType::class, ['row_attr'=>['class'=>'form-group'], 'attr' => ['class'=>'form-control']])
            ->add('model', TextType::class, ['row_attr'=>['class'=>'form-group'], 'attr' => ['class'=>'form-control']])
            ->add('productionYear', TextType::class, ['row_attr'=>['class'=>'form-group'], 'attr' => ['class'=>'form-control']])
            ->add('vin', TextType::class, ['row_attr'=>['class'=>'form-group'], 'attr' => ['class'=>'form-control']])
            ->add('registrationNumber', TextType::class, ['row_attr'=>['class'=>'form-group'], 'attr' => ['class'=>'form-control']])
            ->add('submit', SubmitType::class, ['label' => 'Dodaj do bazy','row_attr'=>['class'=>'form-group'], 'attr' => ['class'=>'btn btn-primary float-right']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
