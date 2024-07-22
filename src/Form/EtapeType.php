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
                'row_attr' => ['class' => 'form'],
                'label' => "Nom de l'étape :"
            ])
            ->add('description', TextareaType::class, [
                'row_attr' => ['class' => 'form', 'placeholder' => "Description de l'étape"],
                'label' => 'Description :'

            ])
            ->add('pdf', FileType::class, [
                'data_class' => null,
                'mapped' => false,
                'row_attr' => ['class' => 'form'],
                'label' => 'PDF :',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez upload un document PDF valide',
                    ])
                ]
            ])
            ->add('video', TextType::class, [
                'row_attr' => ['class' => 'form', 'placeholder' => 'ID Youtube - ex : n7RjlO-beJA'],
                'label' => "ID de la vidéo Youtube :",
                'empty_data' => 'https://www.youtube.com/embed/',
                'required' => false,
            ])
            ->add('ordre', IntegerType::class, [
                'row_attr' => ['class' => 'form']
            ])
            ->add('Niveau', EntityType::class, [
                'class' => Niveau::class,
                'choice_label' => 'nomNiveau',
                'row_attr' => ['class' => 'select form']
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
