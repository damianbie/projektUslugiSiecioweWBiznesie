<?php

namespace App\Form;

use App\Entity\WorkPlace;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class NewWorkPlaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nazwa stanowiska'])
            ->add('min_earnings', NumberType::class,
                ['label' => 'Podstawowe zarobki', 'invalid_message' => 'Zarobki muszą być większe lub równe 0'],)
            ->add('description', TextareaType::class, ['label' => 'Opis stanowiska'])
            ->add('button', SubmitType::class, ['label' => 'Dodaj do bazy'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WorkPlace::class,
        ]);
    }
}
