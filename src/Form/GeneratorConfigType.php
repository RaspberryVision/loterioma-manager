<?php

namespace App\Form;

use App\Entity\GeneratorConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GeneratorConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('min')
            ->add('max')
            ->add(
                'format',
                TextareaType::class,
                [
                    'trim' => false,
                ]
            )
            ->add('seed');

        $builder->get('format')
            ->addModelTransformer(
                new CallbackTransformer(
                    function ($tagsAsArray) {
                        if (!$tagsAsArray) {
                            return '';
                        }

                        return implode("\r\n", array_map(function ($tagLine) {
                            var_dump($tagLine);
                            return implode(', ', $tagLine);
                        }, $tagsAsArray));
                    },
                    function ($tagsAsString) {
                        return explode("\r\n", $tagsAsString);
                    }
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => GeneratorConfig::class,
            ]
        );
    }
}
