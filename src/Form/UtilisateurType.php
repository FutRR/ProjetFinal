<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'row_attr' => ['class' => 'form input-box'],
                'label' => 'Adresse Email',
                'label_attr' => ['class' => 'floating-label'],
                'attr' => ['placeholder' => ' '],
                'disabled' => $options['user_is_google'],
            ])
            ->add('username', TextType::class, [
                'row_attr' => ['class' => 'form input-box'],
                'label' => "Nom d'utilisateur",
                'label_attr' => ['class' => 'floating-label'],
                'attr' => ['placeholder' => ' '],
            ])
            ->add('valider', SubmitType::class, [
                "label" => "Modifier",
                "attr" => [
                    'class' => "btn submit-btn",
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
            'user_is_google' => false,
            'csrf_field_name' => '_token',
        ]);
    }
}
