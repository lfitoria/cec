<?php

namespace App\Form;

use App\Entity\AcademicRequestInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AcademicRequestInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $sippres= 'Vacio';
        $br = '\n';
        $builder
            ->add('summaryObserv', TextareaType::class, [
                    'attr' => ['class' => 'form-control', 'rows' => '4'],
                    'help' => 'Máximo 1500 caracteres.<br>'. $sippres,
                    'help_html' => true,
                    'label_format' => 'Observaciones:',
                    

                ])

            ->add('objetives', TextareaType::class, [
                    'attr' => ['class' => 'form-control', 'rows' => '4'],
                    'help' => 'Máximo 1500 caracteres.',
                    'label' => 'Objetivos:',
                ])
            ->add('questions', TextareaType::class, [
                    'attr' => ['class' => 'form-control', 'rows' => '4'],
                    'help' => 'Máximo 1500 caracteres.',
                    'label' => 'Preguntas:',
                ])
            ->add('hypothesis', TextareaType::class, [
                    'attr' => ['class' => 'form-control', 'rows' => '4'],
                    'help' => 'Máximo 1500 caracteres.',
                    'label' => 'Hipotesis:',
                ])
            ->add('metodologyObserv', TextareaType::class, [
                    'attr' => ['class' => 'form-control', 'rows' => '4'],
                    'help' => 'Máximo 1500 caracteres.',
                    'label' => 'Observaciones:',
                ])
            // ->add('request')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AcademicRequestInfo::class,
        ]);
    }
}
