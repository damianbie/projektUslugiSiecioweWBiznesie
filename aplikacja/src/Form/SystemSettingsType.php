<?php

namespace App\Form;

use App\Controller\Admin\SystemController;
use App\Repository\SystemSettingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SystemSettingsType extends AbstractType
{
    private $_mng = null;
    public function __construct(SystemSettingsRepository $mng)
    {
        $this->_mng = $mng;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $keys = SystemController::$keys;
        foreach ($keys as $key => $keyV)
        {
            $d = $this->_mng->findByKey($key)->getData();

            $builder
                ->add($key, TextType::class, ['label' => $keyV, 'row_attr'=>['class'=>'form-group'], 'attr' => ['value' => $d, 'class'=>'form-control']])
            ;
        }
        
        $builder->add('save', SubmitType::class, ['label' => 'Zapisz','row_attr'=>['class'=>'form-group'], 'attr' => ['class'=>'btn btn-primary float-right']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
