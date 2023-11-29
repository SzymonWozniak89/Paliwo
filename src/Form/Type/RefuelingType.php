<?php

namespace App\Form\Type;

use App\Entity\Refueling;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RefuelingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('refuelingOdometer', NumberType::class, ['label'=>'Stan licznika', 'attr'=>['step'=>'1', 'min'=>'0'], 'required'=>true])
            ->add('refuelingLiters', NumberType::class, ['label'=>'Zatankowana ilość', 'attr'=>['step'=>'0.01', 'min'=>'0.01'], 'required'=>true])
            ->add('refuelingPrice', NumberType::class, ['label'=>'Kwota', 'attr'=>['step'=>'0.01', 'min'=>'0.01'], 'required'=>true])
            ->add('refuelingDate', DateType::class, ['label'=>'Data tankowania', 'required'=>true])
            ->add('submit', SubmitType::class, ['label'=>'Dodaj'])
        ;
    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver){
        $resolver->setDefaults([
            'data_class'=>Refueling::class
        ]);
    }
}