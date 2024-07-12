<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\PasswordStrength;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Les mots de passes doivent être identiques.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'row_attr' => ['class' => 'form'],
                'first_options' => ['label' => 'Mot de passe*', 'attr' => ['class' => 'form']],
                'second_options' => ['label' => 'Répétez le mot de passe*', 'attr' => ['class' => 'form']],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rentrer un mot de papsse',
                    ]),
                    new Regex([
                        'pattern' => "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/",
                        'message' => 'Votre mot de passe doit contenir au moins 1 majuscule, 1 minuscule, 1 caractère spécial, 1 chiffre et doit contenir 8 caractères'
                    ])
                ],
            ])

            // ->add('plainPassword', RepeatedType::class, [
            //     'type' => PasswordType::class,
            //     'options' => [
            //         'attr' => [
            //             'autocomplete' => 'new-password',
            //         ],
            //     ],
            //     'first_options' => [
            //         'constraints' => [
            //             new NotBlank([
            //                 'message' => 'Please enter a password',
            //             ]),
            //             new Length([
            //                 'min' => 8,
            //                 'minMessage' => 'Your password should be at least {{ limit }} characters',
            //                 // max length allowed by Symfony for security reasons
            //                 'max' => 4096,
            //             ]),
            //             new PasswordStrength(),
            //             new NotCompromisedPassword(),
            //         ],
            //         'label' => 'New password',
            //     ],
            //     'second_options' => [
            //         'label' => 'Repeat Password',
            //     ],
            //     'invalid_message' => 'The password fields must match.',
            //     // Instead of being set onto the object directly,
            //     // this is read and encoded in the controller
            //     'mapped' => false,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
