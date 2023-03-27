<?php

namespace App\Form;

use App\Entity\Universities;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UniversitiesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('University', TextType::class, [
                'attr' => [
                    'placeholder' => 'le nom de de l\'université'
                ]
            ])
            ->add('logo_url', FileType::class)
            ->add('login_url', TextType::class, [
                'attr' => [
                    'placeholder' => 'le lien d\'inscription'
                ]
            ])
            ->add('site_url', TextType::class, [
                'attr' => [
                    'placeholder' => 'le site web de l\'universitée'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Universities::class,
        ]);
    }
}
