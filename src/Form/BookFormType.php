<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;


class BookFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',null, ['attr' => ['class' => 'form-title'],
            'label_attr' => ['class' => 'input-label']])

            ->add('ISBN', null, ['attr' => ['class' => 'form-isbn'],
            'label_attr' => ['class' => 'input-label']])

            ->add('author', null, ['attr' => ['class' => 'form-author'],
            'label_attr' => ['class' => 'input-label']])

            ->add('img-upload', FileType::class, [
                'attr' => ['class' => 'form-img'],

                'label_attr' => ['class' => 'input-label'],

                'label' => 'Image (jpg/bmp/png max 100kb)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using attributes
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '120k',
                        'mimeTypes' => [
                            'image/bmp',
                            'image/jpeg',
                            'image/x-png',
                            'image/png',
                            'image/gif'
                        ],
                        'mimeTypesMessage' => 'Please upload an image',
                    ])
                ],
            ])
            
            ->add('Submit', SubmitType::class, ['attr' => ['class' => 'button red-button']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
