<?php

namespace App\Form;

use App\Entity\Document;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'attr' => [
                'class'       => 'border text-gray-100 text-sm rounded-lg  block w-full p-2.5  bg-gray-700 border-gray-600 placeholder-gray-400 focus:border-gray-400 inputs',
                'placeholder' => 'Document Name',
            ],
            'constraints' => [
                new NotBlank(['message' => 'School Name cannot be blank']),
            ],
            'label'      => 'School',
            'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
        ])
        ->add('file', FileType::class, [
            'attr'           => [
                'class' => 'form-control bg-gray-600 block text-sm px-2 font-medium text-gray-100 mb-2',
            ],
            'label' => 'Upload File (PDF or Excel)',
            'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
            'required' => false,
            'mapped' => false,
            'constraints' => [
                new File()
            ],
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
            'data_class' => Document::class,
        ]);
    }
}
