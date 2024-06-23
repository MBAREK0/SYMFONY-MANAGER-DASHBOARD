<?php

namespace App\Form;

use App\Entity\Education;
use App\Entity\Skill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EducationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $skills = $options['skills'];

        $builder
            ->add('school',TextType::class, [
                'attr' => [
                    'class'       => 'form-control relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm',
                    'placeholder' => 'School Name',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'School Name cannot be blank']),
                ],
                'label'      => 'School',
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])
            ->add('degree',TextType::class, [
                'attr' => [
                    'class'       => 'form-control relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm',
                    'placeholder' => 'Degree Name',
                ],
                'label'      => 'Degree',
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])
            ->add('specialty',TextType::class, [
                'attr' => [
                    'class'       => 'form-control relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm',
                    'placeholder' => 'Specialty Name',
                ],
                'label'      => 'Specialty',
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])
            ->add('start_date', null, [
                'widget' => 'single_text',
                'attr' => [
                    'class'       => 'form-control relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm',
                   
                ],
                'label' => 'Start Date',
                'label_attr' => [
                    'class' => 'block text-sm font-medium text-gray-100 mb-2',
                ],
            ])
            ->add('end_date', null, [
                'widget' => 'single_text',
                'attr' => [
                    'class'       => 'form-control relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm',
                   
                ],
                'label' => 'End Date',
                'label_attr' => [
                    'class' => 'block text-sm font-medium text-gray-100 mb-2',
                ],
            ])
            ->add('grade', TextType::class, [
                'attr' => [
                    'class'       => 'form-control relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm',
                    'placeholder' => 'Grade Name',
                ],

                'label'      => 'Grade',
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])
            ->add('description', TextareaType::class, [
                'required'    => false,
                'attr'        => [
                    'class'       => 'form-control relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm',
                    'placeholder' => 'Description',
                    'rows'        => 5, // Optional: set the number of rows
                ],
                'label'      => 'Description',
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])
            ->add('skills', EntityType::class, [
                'class'        => Skill::class,
                'choices'      => $skills,
                'choice_label' => 'name',
                'multiple'     => true,
                'attr'         => ['class' => 'select-multiple'],
                'label'        => 'Skills',
                'label_attr'   => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
    
            ])
            ->add('submit', SubmitType::class, [
                'attr'  => ['class' => 'w-full md:w-1/2 xl:w-1/4 px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none transition-colors mb-3'],
                'label' => 'Save',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Education::class,
            'skills'     => [],
        ]);
    }
}
