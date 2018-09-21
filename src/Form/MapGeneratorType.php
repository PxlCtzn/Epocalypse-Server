<?php

namespace App\Form;

use App\Entity\Map;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\MapGenerator\Algorithm\BasicAlgorithm;
use App\MapGenerator\Algorithm\MapAlgorithm;
use App\MapGenerator\Algorithm\TestAlgorithmTwo;
use App\MapGenerator\Algorithm\TestAlgorithmOne;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use App\MapGenerator\MapGenerator;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class MapGeneratorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('algorithmSelector', ChoiceType::class, array(
                'choices'        => array (
                    new TestAlgorithmOne(),
                    new TestAlgorithmTwo(),
                ),
                /** @var MapAlgorithm $mapAlgorithm */

                'choice_label'  => function($mapAlgorithm, $key, $value) {
                    return $mapAlgorithm->getName();
                },
            ))
            ->add('mapAlgorithm', HiddenType::class)
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                array($this, 'onPreSetData')
                )
            ;
    }
/*
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Map::class,
        ]);
    }
    */

    public function onPreSetData(FormEvent $event)
    {
        /**
         * @var MapGenerator $generator
         */
        $generator = $event->getData();
        echo("<pre>");
        var_dump($generator);
        echo("</pre>");
//         die();
        if(null == $generator->getMapAlgorithm())
        $algorithm = $generator->getMapAlgorithm();

        var_dump($algorithm->getName());
        //$form->add();

        // checks whether the user has chosen to display their email or not.
        // If the data was submitted previously, the additional value that is
        // included in the request variables needs to be removed.
//         if (true === $user['show_email']) {
//             $form->add('email', EmailType::class);
//         } else {
//             unset($user['email']);
//             $event->setData($user);
//         }
    }
}
