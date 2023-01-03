<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Worker;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\WorkerRepository;
use App\Data\Roles;


class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('roles', ChoiceType::class, [
                'label' => 'Uprawnienia',
                'multiple' => true,
                'choices' => Roles::getRoles()] )
            ->add('active', CheckboxType::class, [ 'label' => 'Konto aktywne(pozwala na logowanie do serwisu)', 'required' => false ])
            ->add('worker', EntityType::class, [
                'label' => 'Profil pracownika',
                'required' => true,
                'class' => Worker::class,
                'disabled' => true,
                'query_builder' => function (WorkerRepository  $er) {
                    return $er->createQueryBuilder('s');
                },'choice_label' => function(Worker $work){
                    return sprintf('%s %s (ID: %d)',
                        $work->getName(),
                        $work->getSurname(),
                        $work->getId()
                    );
                },
                'placeholder' => 'Wybierz profil pracownika'
            ])
            ->add('submit',SubmitType::class, ['label' => 'Przypisz konto']);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
