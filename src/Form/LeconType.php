<?php

namespace App\Form;

use App\Entity\Lecon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class LeconType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //dump($options['maitreArmes']);
        $builder
            ->add('rawMaitre', ChoiceType::class,[
                'label' => 'Nom du Maitre d\'armes',
                'choices'=>$options['maitreArmes'],
                'choice_label'=> function($choice){
                    return $choice?$choice->getUsername():'';
                },
                'choice_value'=> function($choice){
                    return $choice?$choice->getUsername():'';
                },
                'multiple'  => false,
                'attr'=>[
                    'class' => 'custom-select form-control text-center mb-3',
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
            'maitreArmes' => [],
        ]);
    }
}
