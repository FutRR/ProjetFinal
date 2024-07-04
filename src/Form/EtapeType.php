<?php

namespace App\Form;

use App\Entity\Etape;
use App\Entity\Niveau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EtapeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomEtape', TextType::class, [
                'attr' => ['class' => 'form']
            ])
            ->add('pdf', TextType::class, [
                'attr' => ['class' => 'form']
            ])
            ->add('video', TextType::class, [
                'attr' => ['class' => 'form']
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'form']
            ])
            ->add('ordre', IntegerType::class, [
                'attr' => ['class' => 'form']
            ])
            ->add('Niveau', EntityType::class, [
                'class' => Niveau::class,
                'choice_label' => 'nomNiveau',
            ])
            ->add('valider', SubmitType::class, [
                "attr" => [
                    'class' => "submit btn"
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etape::class,
        ]);
    }
}
