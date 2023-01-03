<?php

namespace App\Form;

use App\Data\StateOfService;
use App\Entity\Serivce;
use App\Entity\Worker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => false, 'row_attr'=>['class'=>'col-2'], 'attr' => ['class'=>'form-control']])
            ->add('description', TextareaType::class, ['label' => false, 'row_attr'=>['class'=>' col-3'], 'attr' => ['class'=>'form-control']])
            ->add('price_netto', NumberType::class, ['label' => false, 'row_attr'=>['class'=>'col-1'], 'attr' => ['class'=>'form-control']])
            ->add('tax', NumberType::class, ['label' => false, 'row_attr'=>['class'=>'col-1'], 'attr' => ['class'=>'form-control']])
            ->add('service_cost', NumberType::class, ['label' => false, 'row_attr'=>['class'=>'col-1'], 'attr' => ['class'=>'form-control']])
            ->add('made_by', EntityType::class, [
                'label' => false,
                'class' => Worker::class,
                'row_attr' => ['class'=>'col-2'],
                'attr' => ['class'=>'form-control select2'],
                'multiple' => true,
                'placeholder' => '------',
                'required' => false,
                'choice_label' => function(Worker $v) {
                    return sprintf('%s %s(ID: %d)',
                        $v->getName(),
                        $v->getSurname(),
                        $v->getId());
                }])
            ->add('state', ChoiceType::class, [
                'label' => false,
                'row_attr' => ['class'=>'col-2'],
                'attr' => ['class'=>'form-control select2'],
                'choices' => StateOfService::states()
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Serivce::class,
        ]);
    }
}
