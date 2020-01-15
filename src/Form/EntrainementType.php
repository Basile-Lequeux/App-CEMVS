<?php

namespace App\Form;

use App\Entity\Lecon;
use App\Entity\Groupe;
use App\Entity\Entrainement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class EntrainementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('dateStart', DateTimeType::class,[
                "data" => new \DateTime(),
                'date_widget' => "single_text", 
                'time_widget' => "single_text",
                'html5' => true,
                'label' => 'Debut de l\'entrainement (Date et Heure)',
                'attr'=>[
                    'style'=>'margin-left: 40%;',
                ],
            ])
            ->add('dateEnd',DateTimeType::class,[
                'date_widget' => "single_text", 
                'time_widget' => "single_text",
                'html5' => true,
                'label' => 'Fin de l\'entrainement (Date et Heure)',
                'attr'=>[
                    'style'=>'margin-left: 40%;',
                ],    
            ])
            ->add('groupes', EntityType::class, array(
                'label' => 'Groupes acceptés à l\'entrainement',
                'class' => Groupe::class,
                'multiple' => true,
                'expanded' => true,
                'attr'=>[
                    'class'=>'text-center',
                ], 
                'choice_label' => function ($groupe) {
                    return $groupe->getNom();
                }
                
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entrainement::class,
        ]);
    }
}
