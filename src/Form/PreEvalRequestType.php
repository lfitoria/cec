<?php

namespace App\Form;

use App\Entity\PreEvalRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Criterion;
use App\Repository\CriterionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class PreEvalRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('form_target_input', HiddenType::class, [
                'attr' => ['class' => 'form_target_input'],
                'required' => false,
                'mapped' => false
            ])
            ->add('form_finish_input', HiddenType::class, [
                'attr' => ['class' => 'form_finish_input'],
                'required' => false,
                'mapped' => false
            ])
            ->add('observations', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '4'],
                'help' => 'Máximo 1000 caracteres.',
                'label' => 'Observaciones',
                'required' => false,
            ])
            ->add('status', EntityType::class, [
                'class' => Criterion::class,
                'multiple' => false,
                'expanded' => true,
                'query_builder' => function(CriterionRepository $repo) {
                  return $repo->createPopulationQueryBuilder('preEvalStatus');
                },
                'label' => 'Se pre-evalúa la solicitud como:'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PreEvalRequest::class,
        ]);
    }
}