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
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'row_attr' => ['class' => 'form input-box'],
                'label' => 'Adresse Email',
                'label_attr' => ['class' => 'floating-label'],
                'attr' => ['placeholder' => ' ']
            ])
            ->add('username', TextType::class, [
                'row_attr' => ['class' => 'form input-box'],
                'label' => "Nom d'utilisateur",
                'label_attr' => ['class' => 'floating-label'],
                'attr' => ['placeholder' => ' ']
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'mapped' => false,
                'required' => true,
                // 'error_bubbling' => true,
                'invalid_message' => 'Les mots de passes doivent être identiques.',
                'options' => [
                    'row_attr' => ['class' => 'form input-box'],
                    'label_attr' => ['class' => 'floating-label'],
                    'attr' => ['placeholder' => ' ']
                ],
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation du mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rentrer un mot de passe',
                    ]),
                    new Regex([
                        'pattern' => "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-.;,]).{8,}$/",
                        'message' => '1 majuscule, 1 minuscule, 1 caractère spécial, 1 chiffre et 8 caractères'
                    ])
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'row_attr' => ['class' => 'checkbox login-register-checkbox'],
                'label' => "J'ai lu et j'accepte les <a href='{{ path('app_terms')}}' class='login-register-link terms-link'>termes et conditions</a>",
                'label_html' => true,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions.',
                    ]),
                ],
            ])
            ->add('valider', SubmitType::class, [
                "attr" => ['class' => "btn login-register-submit"],
                'label' => "S'inscrire"
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
