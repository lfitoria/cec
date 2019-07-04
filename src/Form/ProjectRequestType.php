<?php

namespace App\Form;

use App\Entity\ProjectRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProjectRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            // ->add('code')
            // ->add('state')
            ->add('extInstitutions', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            // ->add('extInstitutionsAuthorization', CheckboxType::class, [
            //     'label' => 'Autorización de la institución externa pública o privada',
            ->add('extInstitutionsAuthorization', ChoiceType::class, array(
                'choices' => array(
                    'Si' => 1,
                    'No' => 0,
                ),         
                'expanded' => true,
            ))
            ->add('fakeFilesOne', FileType::class, array('multiple' => false, 'mapped' => false))
            ->add('fakeFilesTwo', FileType::class, array('multiple' => false, 'mapped' => false))

            ->add('placeOfStudy', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            // ->add('involvesHumans')
            ->add('involvesHumans', ChoiceType::class, array(
                'choices' => array(
                    'Si' => 1,
                    'No' => 0,
                ),         
                'expanded' => true,
            ))
            // ->add('docHumanInformation')
            ->add('docHumanInformation', ChoiceType::class, array(
                'choices' => array(
                    'Si' => 1,
                    'No' => 0,
                ),         
                'expanded' => true,
            ))
            ->add('projectUnit')
            // ->add('users')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProjectRequest::class,
        ]);
    }
}
