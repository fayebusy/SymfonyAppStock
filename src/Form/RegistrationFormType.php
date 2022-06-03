<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'email',
                EmailType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'label' => 'E-Mail'
                ]
            )
            ->add(
                'prenom',
                TextType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'label' => 'Prenom de l\'utilisateur'
                ]
            )
            ->add(
                'nom',
                TextType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'label' => 'Nom de l\'utilisateur'
                ]
            )
            ->add('roles', EntityType::class, array(
                'attr' => [
                    'class' => 'form-group',
                ],
                'class' => Role::class,
                'mapped' => false,
                'choice_label' => function (Role $role) {
                    return $role->getNom();
                },
                'multiple' => true,
                'expanded' => true,
                'choice_value' => "nom",
                'choice_attr' => function () {
                    // adds a class like attending_yes, attending_no, etc
                    return ['class' => 'form-check-input'];
                },
                'row_attr' => ['class' => 'row'],
                'label_attr' => ['class' => 'form-check-label col-md-6']
            ))
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'class' => 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => [
                'class' => 'form'
            ]
        ]);
    }
}
