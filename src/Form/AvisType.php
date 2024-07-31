<?php

namespace App\Form;

use App\Entity\Avis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu', TextareaType::class, [
                'label' => "Avis :",
                'row_attr' => ['class' => 'avis-textarea'],
                'attr' => ['onkeyup' => 'textAreaAdjust(this)'],
                'required' => false
            ])
            ->add('note', ChoiceType::class, [
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5
                ],
                'choice_label' => function ($choice, $key, $value) {
                    // Vous pouvez définir du HTML pour chaque label ici
                    switch ($value) {
                        case 1:
                            return '<span>1</span>';
                        case 2:
                            return '<span>2</span>';
                        case 3:
                            return '<span>3</span>';
                        case 4:
                            return '<span>4</span>';
                        case 5:
                            return '<span>5</span>';
                    }
                },
                'label_html' => true,
                'label' => 'Note :',
                'label_attr' => ['class' => 'note-label'],
                'attr' => ['class' => 'form radio'],
                'expanded' => true
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
            'data_class' => Avis::class,
        ]);
    }
}
