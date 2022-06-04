<?php

namespace App\Form;

use App\Entity\Sortie;
use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SortieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('quantite',IntegerType::class,[
            'required'=> true,
            'attr'=> array(
                'class'=> 'form-control'
            )
        ])
    ->add('prix',IntegerType::class,[
        'required'=> true,
        'attr'=> array(
            'class'=> 'form-control'
        )
    ])
    ->add('dateSortie',DateType::class,[
        'required'=> true,
        'widget' => 'single_text',
        'attr'=> array(
            'class'=> 'form-control',
            
        )
    ])
    ->add('produit',EntityType::class, array(
        'attr' => [
            'class' => 'form-control',
        ],
        'class' => Produit::class,
        'mapped' => false,
        'choice_label' => function (Produit $produit) {
            return $produit->getLibelle();
        },               
        // 'choice_attr' => function () {
            
        //     return ['class' => 'form-check-input'];
        // },
        // 'row_attr' => ['class' => 'row'],
        // 'label_attr' => ['class' => 'form-check-label col-md-6']
    ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
