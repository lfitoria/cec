<?php

namespace App\Form;

use App\Entity\EvalRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use App\Entity\Criterion;
use App\Repository\CriterionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class EvalRequestType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                // ->add('category')
                // ->add('observations')
                // ->add('date')
                // ->add('current', CheckboxType::class, [
                //     'label' => 'Show this entry publicly?',
                //     'required' => false])
                // ->add('status')
                // ->add('user')
                // ->add('fakeFiles', FileType::class, array('multiple' => true, 'mapped' => false))
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
                    'attr' => ['class' => 'form-control', 'rows' => '4','data-max' => 1000, 'maxlength' => 1000],
                    'help' => 'Máximo 1000 caracteres.',
                    'label' => 'Observaciones',
                    'required' => false,
                ])
                ->add('status', EntityType::class, [
                    'class' => Criterion::class,
                    'multiple' => false,
                    'expanded' => true,
                    'query_builder' => function(CriterionRepository $repo) {
                      return $repo->createPopulationQueryBuilder('evalStatus');
                    },
                    'label' => 'Se evalúa la solicitud como:'
                ])
                ->add('category', EntityType::class, [
                    'class' => Criterion::class,
                    'multiple' => false,
                    'expanded' => true,
                    'query_builder' => function(CriterionRepository $repo) {
                      return $repo->createPopulationQueryBuilder('categoryEvalStatus');
                    },
                    'label' => 'La presente propuesta es de tipo: '
                ])
                ->add('fakeFiles', FileType::class, array(
                    'multiple' => true, 
                    'mapped' => false,
                    'label' => 'Documentos relacionados con este dictamen',
                    'required' => false,
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => EvalRequest::class,
        ]);
    }

}
