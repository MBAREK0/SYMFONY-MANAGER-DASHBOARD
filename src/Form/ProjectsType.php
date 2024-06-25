<?php

namespace App\Form;

use App\Entity\Project;
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

class ProjectsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $skills = $options['skills'];




        $builder
        ->add('name', TextType::class, [
            'attr' => [
                'class'       => 'form-control relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm',
                'placeholder' => 'Enter Project Name',
            ],
            'constraints' => [
                new NotBlank(['message' => 'Project Name cannot be blank']),
            ],
            'label'      => 'Name',
            'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
        ])
        ->add('github_path', TextType::class, [
            'attr' => [
                'class'       => 'form-control relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm',
                'placeholder' => 'Enter Github Path',
            ],
            'constraints' => [
                new NotBlank(['message' => 'Github Path Name cannot be blank']),
            ],
            'label'      => 'Github Path',
            'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
        ])
        ->add('host_path', TextType::class, [
            'required'    => false,
            'attr'        => [
                'class'       => 'form-control relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm',
                'placeholder' => 'Enter Host Path ',
            ],
            'label'      => 'Host Path',
            'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
        ])
        ->add('description', TextareaType::class, [
            'required'    => false,
            'attr'        => [
                'class'       => 'form-control relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm',
                'placeholder' => 'Description',
                'rows'        => 5, // Optional: set the number of rows
            ],
            'label'      => 'Description',
            'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
        ])
        ->add('imageFile', VichImageType::class, [
            'required'       => false,
            'allow_delete'   => true,
            'download_uri'   => true,
            'download_label' => true,
            'image_uri'      => true,
            'asset_helper'   => true,
            'attr'           => [
                'class' => 'form-control bg-gray-600 block text-sm px-2 font-medium text-gray-100 mb-2',
            ],
            'label'      => 'Image',
            'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
        ])
        ->add('technologies', EntityType::class, [
            'class'        => Skill::class,
            'choices'      => $skills,
            'choice_label' => 'name',
            'multiple'     => true,
            'attr'         => ['class' => 'select-multiple'],
            'label'        => 'technologies',
            'label_attr'   => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],

        ])
        ->add('submit', SubmitType::class, [
            'attr'  => ['class' => 'w-full md:w-1/2 xl:w-1/4 px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 focus:outline-none transition-colors mb-3'],
            'label' => 'Save',
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
            'skills'     => null,
        ]);
    }
}
