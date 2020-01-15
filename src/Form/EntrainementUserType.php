<?php

namespace App\Form;

use App\Entity\EntrainementUser;
use Symfony\Component\Form\AbstractType;
use App\Repository\EntrainementRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class EntrainementUserType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', ChoiceType::class,[
                'choices'=>$options['users'],
                'choice_label'=> function($choice){

                    $nomTireur = $choice->getPrenom();
                    $nomTireur .= ' '.$choice->getNom();

                    return $nomTireur;
                },
                'multiple'  => false,
                'required' => true,
                'label' => 'Liste des tireurs pour l\'entrainement: ',
                'attr'=>[
                    'class' => 'custom-select form-control text-center mb-3',
                    'style' => 'background-color:#fff;font-size:18px;'
                ]
            ])
                    
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EntrainementUser::class,
            'users' => [],
        ]);
    }
}
