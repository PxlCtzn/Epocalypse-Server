<?php

namespace App\Form;

use App\Entity\Map;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\MapGenerator\Algorithm\TestAlgorithmOne;
use App\MapGenerator\Algorithm\TestAlgorithmTwo;

class TestAlgorithmTwoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('seaWidth')
            ->add('elevation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
//             'data_class' => TestAlgorithmTwo::class,
        ]);
    }
}