<?php

namespace App\Form\Type;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('carBrand', TextType::class, ['label'=>'Marka', 'required'=>true])
            ->add('carModel', TextType::class, ['label'=>'Model', 'required'=>true])
            ->add('carFuel', TextType::class, ['label'=>'Paliwo', 'required'=>true])
            ->add('carOdometer', NumberType::class, ['label'=>'Stan licznika', 'attr'=>['step'=>'1', 'min'=>'0'], 'required'=>!$options['isEdit'], 'disabled'=>$options['isEdit']])
            ->add('submit', SubmitType::class, ['label'=>'Dodaj'])
        ;
    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver){
        $resolver->setDefaults([
            'data_class'=>Car::class,
            'isEdit'=>false,
            'csrf_protection'=>false
        ]);
    }
}