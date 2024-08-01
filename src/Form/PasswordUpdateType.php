<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class PasswordUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('currentPassword', PasswordType::class, [
                'label' => 'Mot de passe actuel',
                'row_attr' => ['class' => 'form input-box'],
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
                    // new Regex([
                    //     'pattern' => "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/",
                    //     'message' => '1 majuscule, 1 minuscule, 1 caractère spécial, 1 chiffre et 8 caractères'
                    // ])
                ],
            ])
            ->add('valider', SubmitType::class, [
                "attr" => ['class' => "btn login-register-submit"],
                'label' => "Modifier"
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
