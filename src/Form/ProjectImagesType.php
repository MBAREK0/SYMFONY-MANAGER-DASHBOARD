<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\ProjectImages;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProjectImagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('imageFile', VichImageType::class, [
            'required'       => false,
            'allow_delete'   => true,
            'download_uri'   => true,
            'download_label' => true,
            'image_uri'      => true,
            'asset_helper'   => true,
            'attr'           => [
                'class' => 'form-control w-full bg-gray-600 block text-sm px-2 font-medium text-gray-100 my-1',
            ],
            'label'      => 'Screenshot',
            'label_attr' => ['class' => 'block text-sm font-medium text-gray-100 mb-2'],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProjectImages::class,
        ]);
    }
}
