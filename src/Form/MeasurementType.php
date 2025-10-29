<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Measurement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('celsius', NumberType::class , [ 'attr' => ['placeholder' => 'Enter celsius',], ])
            ->add('humidity', NumberType::class , [ 'attr' => ['placeholder' => 'Enter humidity',], ])
            ->add('Wind', NumberType::class , [ 'attr' => ['placeholder' => 'Enter Wind',], ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => \App\Entity\Measurement::class,
            'validation_groups' => function (FormInterface $form) {
                $data = $form->getData();
                return $data && $data->getId() ? ['Edit'] : ['Create'];
            },
        ]);
    }
}
