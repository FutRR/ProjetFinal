<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'attr' => ['class' => 'form'],
                'label' => 'Adresse email*',
            ])
            ->add('username', TextType::class, [
                'attr' => ['class' => 'form'],
                'label' => "Nom d'utilisateur",
                'required' => false
            ])
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
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'row_attr' => ['class' => 'checkbox'],
                'label' => "J'ai lu et j'accepte les <a href='{{ path('app_terms')}}' class='terms-link'>termes et conditions</a>",
                'label_html' => true,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions.',
                    ]),
                ],
            ])
            ->add('valider', SubmitType::class, [
                "attr" => [
                    'class' => "register-submit btn"
                ]
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
