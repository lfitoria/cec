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
            ->add('title', TextType::class, [
                'label' => 'Titulo del proyecto:',
            ])
            // ->add('code')
            // ->add('state')
            ->add('extInstitutions', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
                'label' => 'Otras instituciones externas públicas o privadas:'
            ])
            // ->add('extInstitutionsAuthorization', CheckboxType::class, [
            //     'label' => 'Autorización de la institución externa pública o privada',
            ->add('extInstitutionsAuthorization', ChoiceType::class, array(
                'choices' => array(
                    'Si' => 1,
                    'No' => 0,
                ),         
                'expanded' => true,
                'label' => 'Autorización de la institución externa pública o privada:',
                'attr' => ['class' => 'extInstitutionsAuthorization'],
            ))
            ->add('extInstitutionsAuthorization_file', FileType::class, array('multiple' => false, 
                'mapped' => false,
                'label' => false,
                
            ))

            ->add('placeOfStudy', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
                'label' => 'Lugar donde se realizará el estudio (escuelas, comunidades, instituciones, colegios, etc).'
            ])
            // ->add('involvesHumans')
            ->add('involvesHumans', ChoiceType::class, array(
                'choices' => array(
                    'Si' => 1,
                    'No' => 0,
                ),         
                'expanded' => true,
                'label' => 'La investigación involucra participantes humanos:',
            ))
            // ->add('docHumanInformation')
            ->add('docHumanInformation', ChoiceType::class, array(
                'choices' => array(
                    'Si' => 1,
                    'No' => 0,
                ),         
                'expanded' => true,
                'label' => 'La investigación requiere revisar información documental de seres humanos:',
            ))

            ->add('record_file', FileType::class, array('multiple' => false, 'mapped' => false,
                'label' => 'Acta de la comisión científica o de la Comisión de TFG de grado o posgrado:'
                ))


            //->add('projectUnit')
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
