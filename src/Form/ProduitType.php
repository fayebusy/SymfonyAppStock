<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Entity\Categorie;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Security\Core\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ProduitType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',TextType::class,[
                'required'=> true,
                'attr'=> array(
                    'class'=> 'form-control'
                )
            ])
            // ->add('stock',IntegerType::class,[
            //     'required'=> true,
            //     'attr'=> array(
            //         'class'=> 'form-control'
            //     )
            // ])
            ->add('categorie',EntityType::class, array(
                'attr' => [
                    'class' => 'form-control',
                ],
                'class' => Categorie::class,
                'mapped' => false,
                'choice_label' => function (Categorie $categorie) {
                    return $categorie->getNom();
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
            'data_class' => Produit::class,
        ]);
    }
}
