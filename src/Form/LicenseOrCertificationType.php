<?php

namespace App\Form;

use App\Entity\LicenseAndCertification;
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

class LicenseOrCertificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $skills = $options['skills'];

        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class'       => 'border text-gray-100 text-sm rounded-lg  block w-full p-2.5  bg-gray-700 border-gray-600 placeholder-gray-400 focus:border-gray-400 inputs',
                    'placeholder' => 'Name',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'School Name cannot be blank']),
                ],
                'label'      => 'Name',
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])
            ->add('organization', TextType::class, [
                'attr' => [
                    'class'       => 'border text-gray-100 text-sm rounded-lg  block w-full p-2.5  bg-gray-700 border-gray-600 placeholder-gray-400 focus:border-gray-400 inputs',
                    'placeholder' => 'Organization Name',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Organization Name cannot be blank']),
                ],
                'label'      => 'Organization',
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])
            ->add('date', null, [
                'widget' => 'single_text',
                'attr'   => [
                    'class'       => 'border text-gray-100 text-sm rounded-lg  block w-full p-2.5  bg-gray-700 border-gray-600 placeholder-gray-400 focus:border-gray-400 inputs',

                ],
                'label'      => 'Start Date',
                'label_attr' => [
                    'class' => 'block text-sm font-medium text-gray-100 mb-2',
                ],
            ])
            ->add('description', TextareaType::class, [
                'required'    => false,
                'attr'        => [
                    'class'       => 'border text-gray-100 text-sm rounded-lg  block w-full p-2.5  bg-gray-700 border-gray-600 placeholder-gray-400 focus:border-gray-400 inputs',
                    'placeholder' => 'Description',
                    'rows'        => 5,
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
            ->add('skills', EntityType::class, [
                'class'        => Skill::class,
                'choices'      => $skills,
                'choice_label' => 'name',
                'multiple'     => true,
                'attr'         => ['class' => 'select-skills'],
                'label'        => 'Skills',
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
            'data_class' => LicenseAndCertification::class,
            'skills'     => [],
        ]);
    }
}
