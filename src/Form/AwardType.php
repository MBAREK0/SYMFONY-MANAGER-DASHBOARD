<?php

namespace App\Form;

use App\Entity\Award;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AwardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title_en', TextType::class, [
            'attr' => [
                'class'       => 'border text-gray-100 text-sm rounded-lg  block w-full p-2.5  bg-gray-700 border-gray-600 placeholder-gray-400 focus:border-gray-400 inputs',
                'placeholder' => 'Title (English)',
            ],
            'constraints' => [
                new NotBlank(['message' => 'Title (English) cannot be blank']),
            ],
            'label'      => 'Title (English)',
            'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])
            ->add('title_fr', TextType::class, [
            'attr' => [
                'class'       => 'border text-gray-100 text-sm rounded-lg  block w-full p-2.5  bg-gray-700 border-gray-600 placeholder-gray-400 focus:border-gray-400 inputs',
                'placeholder' => 'Title (French)',
            ],
            'constraints' => [
                new NotBlank(['message' => 'Title (French) cannot be blank']),
            ],
            'label'      => 'Title (French)',
            'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])
            ->add('issuingOrganization_en', TextType::class, [
            'attr' => [
                'class'       => 'border text-gray-100 text-sm rounded-lg  block w-full p-2.5  bg-gray-700 border-gray-600 placeholder-gray-400 focus:border-gray-400 inputs',
                'placeholder' => 'Issuing Organization (English)',
            ],
            'constraints' => [
                new NotBlank(['message' => 'Issuing Organization (English) cannot be blank']),
            ],
            'label'      => 'Issuing Organization (English)',
            'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])
            ->add('issuingOrganization_fr', TextType::class, [
            'attr' => [
                'class'       => 'border text-gray-100 text-sm rounded-lg  block w-full p-2.5  bg-gray-700 border-gray-600 placeholder-gray-400 focus:border-gray-400 inputs',
                'placeholder' => 'Issuing Organization (French)',
            ],
            'constraints' => [
                new NotBlank(['message' => 'Issuing Organization (French) cannot be blank']),
            ],
            'label'      => 'Issuing Organization (French)',
            'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])
            ->add('description_en', TextareaType::class, [
            'required'    => false,
            'attr'        => [
                'class'       => 'border text-gray-100 text-sm rounded-lg  block w-full p-2.5  bg-gray-700 border-gray-600 placeholder-gray-400 focus:border-gray-400 inputs',
                'placeholder' => 'Description (English)',
                'rows'        => 5,
            ],
            'label'      => 'Description (English)',
            'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])
            ->add('description_fr', TextareaType::class, [
            'required'    => false,
            'attr'        => [
                'class'       => 'border text-gray-100 text-sm rounded-lg  block w-full p-2.5  bg-gray-700 border-gray-600 placeholder-gray-400 focus:border-gray-400 inputs',
                'placeholder' => 'Description (French)',
                'rows'        => 5,
            ],
            'label'      => 'Description (French)',
            'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            ])

            ->add('date', null, [
                'widget' => 'single_text',
                'attr'   => [
                    'class'       => 'border text-gray-100 text-sm rounded-lg  block w-full p-2.5  bg-gray-700 border-gray-600 placeholder-gray-400 focus:border-gray-400 inputs',

                ],
                'label'      => 'Issue date',
                'label_attr' => [
                    'class' => 'block text-sm font-medium text-gray-100 mb-2',
                ],
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
            ->add('submit', SubmitType::class, [
            'attr'  => ['class' => 'w-full md:w-1/2 xl:w-1/4 px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 focus:outline-none transition-colors mb-3'],
            'label' => 'Save',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Award::class,

        ]);
    }
}
