<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

final class RateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value', ChoiceType::class, [
                'choices' => [
                    '1 start' => 1,
                    '2 starts' => 2,
                    '3 starts' => 3,
                    '4 starts' => 4,
                    '5 starts' => 5,
                ],
            ]);
    }
}
