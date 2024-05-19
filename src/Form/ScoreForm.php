<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class ScoreForm extends AbstractType
{
    /**
     * @SuppressWarnings(UnusedFormalParameter)
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', null, ['attr' => ['class' => 'form-title',
                                            'required' => true],
            'label_attr' => ['class' => 'input-label']])
            
            ->add('Submit', SubmitType::class, ['attr' => ['class' => 'button red-button']])
        ;
    }

}
