<?php

namespace App\Form;

use App\Entity\SlotsCombination;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SlotsCombinationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('fields', HiddenType::class)
        ;

        $builder->get('fields')
            ->addModelTransformer(
                new CallbackTransformer(
                    function ($array) {
                        if (!$array) {
                            return '';
                        }

                        return json_encode($array);
                    },
                    function ($string) {
                        return json_decode($string);
                        return array_map(function ($line) {
                            return explode(',', $line);
                        }, explode("\r\n", $string));
                    }
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SlotsCombination::class,
        ]);
    }
}
