<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Formations;
use App\Entity\Sanctions;
use App\Entity\Universities;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class FormationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Le titre de la formation'
                ]
            ])
            ->add('generality', CKEditorType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Généralite sur la formation'
                ]
            ])
            ->add('prerequisite', CKEditorType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Les pré-requis pour la formation'
                ]
            ])
            ->add('purpose', CKEditorType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Le but de la formation'
                ]
            ])
            ->add('finality', CKEditorType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Finalité de la formation'
                ]
            ])
            ->add('contents', CKEditorType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Le contenue de la formation'
                ]
            ])
            ->add('prices', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Le prix de la formation'
                ]
            ])
            ->add('duration', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ladurée de la formation'
                ]
            ])
            ->add('priority')
            ->add('vignette_url', FileType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'La vignette de la formation'
                ]
            ])
            ->add('sanction', EntityType::class, [
                'class' => Sanctions::class,
                'choice_label' => 'sanction',
                'multiple' => false,
                'expanded' => true
            ])
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'category',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false
            ])
            ->add('university', EntityType::class, [
                'class' => Universities::class,
                'choice_label' => 'university',
                'multiple' => false,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formations::class,
        ]);
    }
}
