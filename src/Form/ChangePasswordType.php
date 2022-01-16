<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fistname', TextType::class,[
                'label' => 'Mon prénom',
                'disabled' => true,            
            ])
            
            ->add('lastname',TextType::class,[
                'label' => 'Mon nom',
                'disabled' => true
            ])
            ->add('email',EmailType::class,[
                'label' => 'Mon adresse email',
                'disabled' => true
            ])
            ->add('hold_password',PasswordType::class,[
                'label' => 'Mon mot de passe actuel',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Veiller saisir votre mot de passe actuel'
                ]
            ])
            ->add('new_password',RepeatedType::class,[
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' =>'Le mot de passe et la confirmation doivent etre identique!!',
                'label' => 'Votre mot de passe',
                'required' => true,
                'first_options'=> ['label' => 'Nouveau mot de passe' ,
                                    'attr' => [
                                        'placeholder' =>'Renseignez le nouveau mot de passe'
                                    ]
                ],
                'second_options'=> ['label' => 'Confiremer votre mot de passe',
                                    'attr' => [
                                        'placeholder' =>'Confirmez le nouveau mot de passe'
                                    ]
                 ]
            ])
            ->add('submit', SubmitType::class,[
                'label' => "Mettre à jour"
            ])
          
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
