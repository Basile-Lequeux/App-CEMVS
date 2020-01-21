<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Groupe;
use App\Entity\UserArbitre;
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
                    'Autre' => 'autre',
                ],
                "label" => "Genre de l'utilisateur",
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
            ->add('blason',ChoiceType::class,[
                "choices" => [
                    'Blason Jaune' => 'Jaune',
                    'Blason Rouge' => 'Rouge',
                    'Blason Bleu' => 'Bleu',
                    'Blason Vert' => 'Vert',   
                ],
                "label" => "Blason de l'utilisateur",
                'attr'=>[
                    'class' => 'custom-select form-control text-center mb-3',
                    'style' => 'background-color:#fff;font-size:15px;'
                ],
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
                "label" => "Catégorie de l'utilisateur",
                'attr'=>[
                    'class' => 'custom-select form-control text-center mb-3',
                    'style' => 'background-color:#fff;font-size:15px;'
                ],
            ])
            ->add('arbitre', EntityType::class, array(
                'label' => 'Niveau Arbitre',
                'class' => UserArbitre::class,
                'multiple' => false,
                'expanded' => false,
                'attr'=>[
                    'class' => 'custom-select form-control text-center mb-3',
                    'style' => 'background-color:#fff;font-size:15px;'
                ],
                'choice_label' => function ($groupe) {
                    return $groupe->getNiveauArbitre();
                }
                
            ))
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
