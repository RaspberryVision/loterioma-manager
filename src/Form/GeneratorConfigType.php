<?php

namespace App\Form;

use App\Entity\GeneratorConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GeneratorConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('min')
            ->add('max')
            ->add('format')
            ->add('seed')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GeneratorConfig::class
        ]);
    }
}
