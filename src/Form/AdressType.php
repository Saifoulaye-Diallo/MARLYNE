<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TypeTextType::class,[
                'label' =>'Quel nom souhaiez-vous donner à votre adresse?',
                'attr' => [
                    'placeholder' => 'Nommez votre aderesse',
                ]
            ])
            ->add('firstname',TypeTextType::class,[
                'label' =>'Votre prenom',
                'attr' => [
                    'placeholder' => 'Entrer votre prenom',
                ]
            ])
            ->add('lastname',TypeTextType::class,[
                'label' =>'Votre nom',
                'attr' => [
                    'placeholder' => 'Entrer votre nom',
                ]
            ])
            ->add('company',TypeTextType::class,[
                'label' =>'Votre société (facultatif)',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Entrer le nom de votre société',
                    
                ]
            ])
            ->add('address',TypeTextType::class,[
                'label' =>'Votre adresse',
                'attr' => [
                    'placeholder' => 'ex. 8 rue de ....',
                ]
            ])
            ->add('postal',TypeTextType::class,[
                'label' =>'Votre code postal',
                'attr' => [
                    'placeholder' => 'Code postal',
                ]
            ])
            ->add('city',TypeTextType::class,[
                'label' =>'Votre ville',
                'attr' => [
                    'placeholder' => 'Entrer otrre ville',
                ]
            ])
            ->add('country',CountryType::class,[
                'label' =>'Pays',
                'attr' => [
                    'placeholder' => 'Entrer votre pays',
                    'class' => 'form-control'
                ]
            ])
            ->add('phone',TelType::class,[
                'label' =>'Votre telephone',
                'attr' => [
                    'placeholder' => 'Entrer votre téléphone',
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label' => 'Ajouter mon adresse',
                'attr' => [
                    'class' => 'btn btn-info btn-block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
