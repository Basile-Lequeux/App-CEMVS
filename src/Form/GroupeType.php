<?php

namespace App\Form;

use App\Entity\Groupe;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class GroupeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('users', EntityType::class, array(
                'label' => 'Ajouter tireur au groupe',
                'class' => User::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => function ($users) {
                    return $users->getUsername();
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Groupe::class,
        ]);
    }
}
