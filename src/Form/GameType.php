<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
            ->add('generatorConfig', GeneratorConfigType::class)
            ->add(
                'symbols',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => GameSymbolType::class,
                    'allow_add' => true,
                    'prototype' => true,
                    'by_reference' => false,
                    'entry_options' => [
                        'attr' => ['class' => 'email-box'],
                    ],
                ]
            )
            ->add(
                'combinations',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => SlotsCombinationType::class,
                    'allow_add' => true,
                    'prototype' => true,
                    'by_reference' => false,
                    'entry_options' => [
                        'attr' => ['class' => 'email-box'],
                    ],
                ]
            );
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
