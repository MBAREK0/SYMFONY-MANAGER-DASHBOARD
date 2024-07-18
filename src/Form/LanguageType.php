<?php

namespace App\Form;

use App\Entity\Language;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LanguageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class'       => 'border text-gray-100 text-sm rounded-lg  block w-full p-2.5  bg-gray-700 border-gray-600 placeholder-gray-400 focus:border-gray-400 inputs',
                    'placeholder' => 'Enter The Medium Name',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Medium Name cannot be blank']),
                ],
                'label'      => 'Name',
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])
            ->add('proficiency', ChoiceType::class, [
                'choices' => [
                    'A1 (Beginner)' => 'Beginner',
                    'A2 (Elementary)' => 'Elementary',
                    'B1 (Intermediate)' => 'Intermediate',
                    'B2 (Upper-Intermediate)' => 'Upper-Intermediate',
                    'C1 (Advanced)' => 'Advanced',
                    'C2 (Proficient)' => 'Proficient',
                ],
                'attr' => [
                    'class' => 'border text-gray-100 text-sm rounded-lg  block w-full p-2.5  bg-gray-700 border-gray-600 placeholder-gray-400 focus:border-gray-400 inputs',
                    'placeholder' => 'Select Proficiency Level',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Proficiency level cannot be blank']),
                ],
                'label' => 'Proficiency Level',
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])
            ->add('submit', SubmitType::class, [
                'attr'  => ['class' => 'w-full md:w-1/2 xl:w-1/4 px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 focus:outline-none transition-colors mb-3'],
                'label' => 'Save',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Language::class,
        ]);
    }
}
