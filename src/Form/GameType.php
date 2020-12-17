<?php

namespace App\Form;

use App\DTO\Condition;
use App\DTO\Strategy;
use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('floor')
            ->add('condition', ChoiceType::class, [
                'choices' => Condition::CONNDITIONS_LABELS
            ])
            ->add('strategy', ChoiceType::class, [
                'choices' => Strategy::STRATEGEES_LABELS
            ])
            ->add('price', NumberType::class, [
                'disabled' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
