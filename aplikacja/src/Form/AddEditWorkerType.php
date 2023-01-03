<?php

namespace App\Form;

use App\Entity\Worker;
use App\Entity\WorkPlace;
use App\Form\DataTransformer\DateToStringTransformer;
use App\FormTypes\DatePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\Types\DataPickerType;
use App\Repository\WorkPlaceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AddEditWorkerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Imie'])
            ->add('surname', TextType::class, ['label' => 'Nazwisko'])
            ->add('birthDate', DatePickerType::class, ['label' => 'Data urodzenia'])
            ->add('phoneNumber', TextType::class, ['label' => 'Numer telefonu'])
            ->add('hiredAt', DatePickerType::class, ['label' => 'Data zatrudnienia'])
            ->add('bonus', NumberType::class, ['label' => 'premia'])
            ->add('workPlace', EntityType::class, [
                'label' => 'Stanowisko',
                'required' => true,
                'class' => WorkPlace::class,
                'query_builder' => function (WorkPlaceRepository  $er) {
                    return $er->getAll();
                },'choice_label' => function(WorkPlace $work){
                    return sprintf('%s %s zł (ID: %d)',
                    $work->getName(),
                    $work->getMinEarnings(),
                    $work->getId()
                    );
                },
                'placeholder' => 'Wybierz stanowisko'
                ])
                ->add('submit', SubmitType::class, ['label' => 'Zapisz zmiany'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Worker::class,
        ]);
    }
}