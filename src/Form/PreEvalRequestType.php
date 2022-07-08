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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
                'attr' => ['class' => 'form-control', 'rows' => '4','data-max' => 3000, 'maxlength' => 3000, 'data-char' => 'pre_eval_text_area'],
                'help' => 'Máximo 3000 caracteres.',
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
                'label' => 'Se preevalúa la solicitud como:',
               
                
            ])
            ->add('form_finish_input', HiddenType::class, [
                'attr' => ['class' => 'form_finish_input'],
                'required' => false,
                'mapped' => false
            ])
            // ->add('status', ChoiceType::class,
            // [ 'choices' => ['a' => 'a', 'b' => 'b']
            // , 'expanded' => true
            // , 'multiple' => true
            // , 'attr' => ['class' => 'AAA']
            // ,  'choice_attr' => ['a' => ['title' => 'BBB', 'required' => true], 'b' => ['class' => 'BBB', 'required' => true]]
            // , 'required' => true
            // , 'mapped' => false
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PreEvalRequest::class,
        ]);
    }
}
