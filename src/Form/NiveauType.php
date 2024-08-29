<?php

namespace App\Form;

use App\Entity\Niveau;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NiveauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomNiveau', TextType::class, [
                'label' => 'Nom du niveau',
                'label_attr' => ['class' => 'floating-label'],
                'attr' => ['placeholder' => ' '],
                'row_attr' => ['class' => 'form input-box']
            ])
            // ->add('prix', FloatType::class, [
            //     'label' => 'Prix',
            //     'row_attr' => ['class' => 'prix form']
            // ])
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
            'data_class' => Niveau::class,
        ]);
    }
}
