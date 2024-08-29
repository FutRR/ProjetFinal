<?php

namespace App\Form;

use App\Entity\Etape;
use App\Entity\Niveau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
                'row_attr' => ['class' => 'form input-box'],
                'label_attr' => ['class' => 'floating-label'],
                'attr' => ['placeholder' => ' '],

                'label' => "Nom de l'étape :"
            ])
            ->add('description', TextareaType::class, [
                'row_attr' => ['class' => 'form input-box'],
                'label' => 'Description',
                'label_attr' => ['class' => 'floating-label'],
                'attr' => ['placeholder' => ' '],


            ])
            ->add('pdf', FileType::class, [
                'data_class' => null,
                'mapped' => false,
                'row_attr' => ['class' => 'form input-file'],
                'attr' => ['placeholder' => ' '],
                'label' => 'PDF :',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5000k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez upload un document PDF valide',
                    ])
                ]
            ])
            ->add('video', TextType::class, [
                'row_attr' => ['class' => 'form input-box', 'placeholder' => 'ID Youtube - ex : n7RjlO-beJA'],
                'label_attr' => ['class' => 'floating-label'],
                'attr' => ['placeholder' => ' '],

                'label' => "ID de la vidéo Youtube :",
                'empty_data' => 'https://www.youtube.com/embed/',
                'required' => false,
            ])
            ->add('ordre', IntegerType::class, [
                'row_attr' => ['class' => 'form input-box'],
                'label_attr' => ['class' => 'floating-label'],
                'attr' => ['placeholder' => ' '],

            ])
            ->add('Niveau', EntityType::class, [
                'class' => Niveau::class,
                'choice_label' => 'nomNiveau',
                'row_attr' => ['class' => 'select form input-box'],

            ])
            ->add('valider', SubmitType::class, [
                "attr" => [
                    'class' => "btn"
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
