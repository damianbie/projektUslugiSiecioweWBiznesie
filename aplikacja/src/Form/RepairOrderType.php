<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\RepairOrder;
use App\Entity\Vehicle;
use App\Entity\Serivce;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepairOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client', EntityType::class, [
                'label' => 'Klient:',
                'class'=> Client::class,
                'row_attr' => ['class'=>'form-group'],
                'attr' => ['class'=>'form-control select2'],
                    'placeholder' => 'Wybierz klienta jeżeli go nie ma dodaj go w oddzielnej zakładce',
                'choice_label' => function(Client $c) {
                    return ($c->getIsCompany())?
                        sprintf('%s %s (ID: %d)', $c->getName(), $c->getNip(), $c->getId())
                        :sprintf('%s %s (ID: %d)', $c->getName(), $c->getSurname(), $c->getId());
                }])
            ->add('vehicle', EntityType::class, [
                'label' => 'Naprawiany pojazd:',
                'class' => Vehicle::class,
                'row_attr' => ['class'=>'form-group'],
                'attr' => ['class'=>'form-control select2'],
                'placeholder' => 'Wybierz naprawiany pojazd jeżeli go nie ma dodaj go w oddzielnej zakładce',
                'choice_label' => function(Vehicle $v) {
                    return sprintf('%s %s nr. Rej: %s Vin:%s (ID: %d)',
                        $v->getManufacturer(),
                        $v->getModel(),
                        $v->getRegistrationNumber(),
                        $v->getVin(),
                        $v->getId());
                }])
            ->add('additionalInfo', TextareaType::class,[
                'label'     => 'komentarz dla klienta',
                'row_attr'  => ['class'=>'form-group'],
                'attr'      => ['class'=>'form-control'],
                'required'  => false,
            ])
            ->add('additionalInfoPriv', TextareaType::class,[
                'label'     => 'komentarz dla pracowników',
                'row_attr'  => ['class'=>'form-group'],
                'attr'      => ['class'=>'form-control'],
                'required'  => false,
            ])
            ->add('services', CollectionType::class, [
                'label' => false,
                'mapped' => false,
                'entry_type' => ServiceType::class,
                'allow_add' => true,
                'prototype' => true,
                'entry_options' => [
                    'attr' => ['class' => 'row'],
                ],
            ])
            ->add('submit', SubmitType::class, ['label' => 'Dodaj do bazy','row_attr'=>['class'=>'form-group'], 'attr' => ['class'=>'btn btn-primary float-right']])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RepairOrder::class,
        ]);
    }
}
