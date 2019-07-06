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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ProjectRequestType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', TextType::class, [
                    'label' => 'Titulo del proyecto:',
                ])
                ->add('extInstitutions', TextareaType::class, [
                    'attr' => ['class' => 'tinymce', 'rows' => '4'],
                    'label' => 'Otras instituciones externas públicas o privadas:'
                ])
                ->add('extInstitutionsAuthorization', ChoiceType::class, array(
                    'choices' => array(
                        'Si' => 1,
                        'No' => 0,
                    ),
                    'data' => 0,
                    'expanded' => true,
                    'label' => 'Autorización de la institución externa pública o privada:',
                    'attr' => ['class' => 'extInstitutionsAuthorization'],
                ))
                ->add('placeOfStudy', TextareaType::class, [
                    'attr' => ['class' => 'tinymce', 'rows' => '4'],
                    'label' => 'Lugar donde se realizará el estudio (escuelas, comunidades, instituciones, colegios, etc).'
                ])
                ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                    $projectRequest = $event->getData();
                    $form = $event->getForm();

                    if (!$projectRequest || null === $projectRequest->getId()) {
                        $data = true;
                        $default = 0;
                    } else {
                        $data = false;
                        $default = '';
                    }
                    $form->add('docHumanInformationFiles', FileType::class, array('multiple' => true, 'mapped' => false, 'required' => $data, 'label' => 'Acta de la comisión científica o de la Comisión de TFG de grado o posgrado:'));
                    $form->add('extInstitutionsAuthorizationFiles', FileType::class, array('multiple' => true, 'mapped' => false, 'required' => $data, 'label' => false));
                    $form->add('involvesHumans', ChoiceType::class, array(
                        'choices' => array(
                            'Si' => 1,
                            'No' => 0,
                        ),
                        'expanded' => true,
                        'label' => 'La investigación involucra participantes humanos:',
                    ));
                    $form->add('docHumanInformation', ChoiceType::class, array(
                        'choices' => array(
                            'Si' => 1,
                            'No' => 0,
                        ),
                        'expanded' => true,
                        'label' => 'La investigación requiere revisar información documental de seres humanos:',
                    ));
                })
        //->add('projectUnit')
        // ->add('users')
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => ProjectRequest::class,
        ]);
    }

    public static function getSubscribedEvents() {
        return [FormEvents::PRE_SET_DATA => 'preSetData'];
    }

    public function preSetData(FormBuilderInterface $builder, FormEvent $event) {
        $projectRequest = $event->getData();
        $form = $event->getForm();

        if (!$projectRequest || null === $projectRequest->getId()) {
            $data = true;
        } else {
            $data = false;
        }
        $builder->add('docHumanInformationFiles', FileType::class, array('multiple' => true, 'mapped' => false, 'required' => $data, 'label' => 'Acta de la comisión científica o de la Comisión de TFG de grado o posgrado:'));
        $builder->add('extInstitutionsAuthorizationFiles', FileType::class, array('multiple' => true, 'mapped' => false, 'required' => $data, 'label' => false));
    }

}