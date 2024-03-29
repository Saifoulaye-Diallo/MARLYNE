<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           ->add('fistname',TextType::class,[
               'label' => 'Votre prenom',
               'attr' => [
                   'placeholder' => 'Merci de saisir votre nom'
               ]
           ])
            ->add('lastname',TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre nom'
                ]
            ])
            ->add('email',EmailType::class,[
                'label' => 'Votre email',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre adresse mail'
                ]
            ])
            ->add('password',RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' =>'Le mot de passe et la confirmation doivent etre identique!!',
                'label' => 'Votre mot de passe',
                'required' => true,
                'first_options'=> ['label' => 'Mot de passe' ,
                                    'attr' => [
                                        'placeholder' =>'Merci de saisir votre mot de passe'
                                    ]
                ],
                'second_options'=> ['label' => 'Confiremer votre mot de passe',
                                    'attr' => [
                                        'placeholder' =>'Merci de confirmer votre mot de passe'
                                    ]
                 ]
            ])
            ->add('submit', SubmitType::class,[
                'label' => "S'inscrire"
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
