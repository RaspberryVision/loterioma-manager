<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add(
                'type',
                ChoiceType::class,
                [
                    'choices' => [
                        'Dice' => Game::TYPE_DICE,
                        'Slots' => Game::TYPE_SLOTS,
                    ],
                ]
            )
            ->add('generatorConfig', GeneratorConfigType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Game::class
                // Configure your form options here
            ]
        );
    }
}
