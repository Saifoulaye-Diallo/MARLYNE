<?php

namespace App\Form;
use Symfony\Component\Form\AbstractType;
use App\Classe\Search;
use App\Entity\Category;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class SearchType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'crsf_protection' => false,
        ]);
    }
    
    public function getBlockPrefix()
    {
        return '';
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('string',TextType::class,[
            'label' => 'Rechercher',
            'required' => false,
            'attr' => [
                'placeholder' => 'Votre recherche',
                'class' => 'form-control-sm',
                
            ]
            ])
        ->add('categories',EntityType::class,[
            'label' => false,
            'required' => false,
            'class' => Category::class,
            'multiple' => true,
            'expanded' => true
        ])
        ->add('submit',SubmitType::class,[
            'label' => 'filtrer',
            'attr' => [
                'class' => 'btn-block btn-info'
            ]
         ])
        ;
    }
}