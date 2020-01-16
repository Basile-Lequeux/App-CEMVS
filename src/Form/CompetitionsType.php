<?php

namespace App\Form;

use App\Entity\Competitions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class CompetitionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('categorieAge',ChoiceType::class,[
                "choices" => [
                    'M5 (≤ 5ans)' => 'M5',
                    'M7 (6 à 7ans)' => 'M7',
                    'M9 (8 à 9ans)' => 'M9',
                    'M11 (10 à 11ans)' => 'M11',
                    'M13 (12 à 13ans)' => 'M13',
                    'M15 (14 à 15ans)' => 'M15',
                    'M17 (16 à 17ans)' => 'M17',
                    'M20 (18 à 20ans)' => 'M20',
                    'Séniors (21 à 39 ans)' => 'Seniors',
                    'Vétérans 1 (40 à 49ans)' => 'Veteran1',
                    'Vétérans 2 (50 à 59ans)' => 'Veteran1',
                    'Vétérans 3 15 (60 à 69ans)' => 'Veteran3',
                    'Vétérans 4 15 (≥ 70 ans)' => 'Veteran4',
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
