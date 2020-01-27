<?php

namespace App\Form;

use App\Entity\Competitions;
use App\Entity\CategorieAge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class CompetitionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('Name', TextType::class,[      
            'label' => 'Nom de de la compétition'
            
        ])

        ->add('dateStart', DateTimeType::class,[
            'date_widget' => "single_text", 
            'time_widget' => "single_text",
            'html5' => true,
            'label' => 'Debut de la compétition (Date et Heure)',
            'attr'=>[
                'style'=>'margin-left: 40%;',
            ],
        ])
        ->add('dateEnd',DateTimeType::class,[
            'date_widget' => "single_text", 
            'time_widget' => "single_text",
            'html5' => true,
            'label' => 'Fin de la compétition (Date et Heure)',
            'attr'=>[
                'style'=>'margin-left: 40%;',
            ],    
        ])
        ->add('CategorieAge', EntityType::class,[
            "label" => "Catégorie",
            'class' => CategorieAge::class,
            'multiple' => false,
            'expanded' => false,
            "attr"=>[
                'class'=>'text-center',
            ]
        ])
            ->add('arme', ChoiceType::class,[
                "choices" => [
                    'Sabre' => 'Sabre',
                    'Epée' => 'Epée',
                    'Fleuret' => 'Fleuret',
                ],
                "label" => "Arme nécessaire pour la compétition",
                "attr"=>[
                    'class'=>'text-center',
                ]
            ])
            ->add('blason',ChoiceType::class,[
                "choices" => [
                    'Blason Jaune' => 'Jaune',
                    'Blason Rouge' => 'Rouge',
                    'Blason Bleu' => 'Bleu',
                    'Blason Vert' => 'Vert', 
                ],
                "label" => "Blason conseillé pour la compétition",
                "attr"=>[
                    'class'=>'text-center',
                ]
            ])

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Competitions::class,
        ]);
    }
}
