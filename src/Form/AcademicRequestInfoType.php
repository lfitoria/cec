<?php

namespace App\Form;

use App\Entity\AcademicRequestInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\Criterion;
use App\Repository\CriterionRepository;

class AcademicRequestInfoType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $sippres = 'Vacio';
    $br = '\n';
    $builder
            ->add('form_target_input', HiddenType::class, [
                'attr' => ['class' => 'form_target_input'],
                'required' => false,
                'mapped' => false
            ])
            ->add('summaryObserv', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '4'],
                'help' => 'Máximo 1500 caracteres.<br>' . $sippres,
                'help_html' => true,
                'label_format' => 'Observaciones:',
                // 'label_format' => 'Resumen del estudio (antecedentes y justificación):',                
                'required' => false,
            ])
            ->add('objetives', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '4'],
                'help' => 'Máximo 1500 caracteres.',
                'label' => 'Objetivos:',
                'required' => false,
            ])
            ->add('questions', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '4'],
                'help' => 'Máximo 1500 caracteres.',
                'label' => 'Preguntas:',
                'required' => false,
            ])
            ->add('hypothesis', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '4'],
                'help' => 'Máximo 1500 caracteres.',
                'label' => 'Hipotesis:',
                'required' => false,
            ])
            ->add('metodologyObserv', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '4'],
                'help' => 'Máximo 1500 caracteres.',
                'label' => 'Observaciones:',
                'required' => false,
            ])
            ->add('invType', EntityType::class, [
                'class' => Criterion::class,
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function(CriterionRepository $repo) {
                  return $repo->createPopulationQueryBuilder('investigationType');
                },
                'label' => 'Tipo de investigación:',
                'help' => '(Marque todas las opciones que sean necesarias)'
    ]);
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
        'data_class' => AcademicRequestInfo::class,
    ]);
  }

}
