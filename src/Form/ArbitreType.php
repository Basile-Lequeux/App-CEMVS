<?php

namespace App\Form;

use App\Entity\CompetitionsUser;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArbitreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $datas = $builder->getData();
        $builder
            
        ->add('listeArbitre', ChoiceType::class,[
            'label' => 'Arbitre',
            'choices' => $datas->getListeArbitre(),
            'choice_label' => function ($tireur)
            {
                $nomTireur = $tireur->getPrenom();
                $nomTireur .= ' '.$tireur->getNom();

                return $nomTireur;  
            },
            'multiple' => false,
            'attr'=>[
                'class' => 'text-center mb-3',
                'style' => 'background-color:#fff;font-size:18px;'
            ],
            'required' => true,
        ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CompetitionsUser::class,
        ]);
    }
}
