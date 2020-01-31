<?php

namespace App\Form;

use App\Entity\Lecon;
use App\Entity\User;
use App\Entity\Entrainement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MaitreLeconType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $datas = $builder->getData();

        $builder
        ->add('listeEntrainement', ChoiceType::class,[
            'label' => 'date',
            'choices' => $datas->getListeEntrainement(),
            // 'choice_value'=> function ($entrainement){
            //     $id = $entrainement?$entrainement->getId():'';
            //     return $id;
            // },
            'choice_label'=> function ($entrainement)
            {
                $date = $entrainement->getDateStart()->format('d/m/Y H:i:s');
                
                return $date;
            },

            'multiple' => false,
            
            'attr'=>[
                'class' => 'text-center mb-3',
                'style' => 'background-color:#fff;font-size:18px;'
            ],
            'required' => true,
            
        ])

        ->add('listeTireur', ChoiceType::class,[
            'label' => 'Tireur',
            'choices' => $datas->getListeTireur(),
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
    

        ->add('informations', TextareaType::class,[
            'label' => 'Informations ou remarque sur la leçon',
            'required' => false,
        ])
                
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lecon::class,
        ]);
    }
}
