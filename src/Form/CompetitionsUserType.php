<?php

namespace App\Form;

use App\Entity\CompetitionsUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CompetitionsUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   if(!$options['update']){
            $builder
                ->add('competition')
            ;
        }else{
            $builder
                ->add('place',IntegerType::class,[
                    'label'=> 'Indiquez la place à laquelle vous avez fini',
                    'attr'=>[
                        'class' => 'text-center'
                    ],
                    'required'=>true,
                ])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CompetitionsUser::class,
            'csrf_protection' => false,
            'update' => null,
        ]);
    }
}
