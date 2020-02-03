<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Groupe;
use App\Entity\CategorieAge;
use App\Entity\Arbitre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
            'label' => "Nom"
            ])
            ->add('prenom',TextType::class,[
            'label' => "Prenom"
            ])        
            ->add('username',TextType::class,[
                'label' => "Identifiant de l'utilisateur"
            ])
            ->add('raw_password',PasswordType::class,[
                'label' => "Mot de passe de l'utilisateur"
            ])
            ->add('role',ChoiceType::class,[
                "choices" => [
                    'Tireur' => 'ROLE_TIREUR',
                    'Maitre d\'armes' => 'ROLE_MAITRE',
                    'Administrateur' => 'ROLE_ADMIN',
                    
                ],
                "label" => "Role dans l'application",
                'attr'=>[
                    'class' => 'custom-select form-control text-center mb-3',
                    'style' => 'background-color:#fff;font-size:15px;'
                ],
            ])
            ->add('genre',ChoiceType::class,[
                "choices" => [
                    'Homme' => 'homme',
                    'Femme' => 'femme',
                ],
                "label" => "Sexe de l'utilisateur",
                'attr'=>[
                    'class' => 'custom-select form-control text-center mb-3',
                    'style' => 'background-color:#fff;font-size:15px;'
                ],
            ])
            ->add('dateNaissance', BirthdayType::class, [
                'widget' => "single_text", 
                "label" => "Date de Naissance",
                'html5' => true,
                'attr'=>[
                    'class' => 'custom-select text-center mb-3',
                                       
                ],
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ] 

                ])
            // ->add('blason',ChoiceType::class,[
            //     "choices" => [
            //         'Blason Jaune' => 'Jaune',
            //         'Blason Rouge' => 'Rouge',
            //         'Blason Bleu' => 'Bleu',
            //         'Blason Vert' => 'Vert',   
            //     ],
            //     "label" => "Blason de l'utilisateur",
            //     'attr'=>[
            //         'class' => 'custom-select form-control text-center mb-3',
            //         'style' => 'background-color:#fff;font-size:15px;'
            //     ],
            // ])
            ->add('CategorieAge', EntityType::class,[
                "label" => "Catégorie(s)",
                'class' => CategorieAge::class,
                'multiple' => true,
                'expanded' => true,
                "attr"=>[
                    'class'=>'text-center',
                ]
            ])
 
            ->add('groupe', EntityType::class, array(
                'label' => 'Groupe de l\'utilisateur',
                'class' => Groupe::class,
                'multiple' => false,
                'expanded' => false,
                'attr'=>[
                    'class' => 'custom-select form-control text-center mb-3',
                    'style' => 'background-color:#fff;font-size:15px;'
                ],
                'choice_label' => function ($groupe) {
                    return $groupe->getNom();
                }
                
            ))
            
            
            ->add('zoneArbitre', EntityType::class,[
                "label" => "Niveau d'Arbitrage(s)",
                'class' => Arbitre::class,
                'expanded' => true,
                "attr"=>[
                    'class'=>'text-center',
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
