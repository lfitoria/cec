<?php

namespace App\Form;

use App\Entity\ProjectRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
                'label' => 'Otras instituciones externas públicas o privadas:',
                'required' => false
            ])
            ->add('placeOfStudy', TextareaType::class, [
                'attr' => ['class' => 'tinymce', 'rows' => '4'],
                'label' => 'Lugar donde se realizará el estudio (escuelas, comunidades, instituciones, colegios, etc).',
                'required' => false
            ])
            ->add('form_target_input', HiddenType::class, [
                'attr' => ['class' => 'form_target_input'],
                'required' => false,
                'mapped' => false
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
              $projectRequest = $event->getData();
              $form = $event->getForm();

              if (!$projectRequest || null === $projectRequest->getId()) {
                $data = false;
                $default = 0;
              } else {
                $data = false;
                $default = '';
              }

              $userType = "student";
              if ($userType === "student") {
                $form->add('tutorName', TextType::class, [
                    'label' => 'Nombre del tutor:',
                    'mapped' => false
                ]);
                $form->add('tutorId', TextType::class, [
                    'label' => 'Cédula:',
                    'mapped' => false
                ]);
                $form->add('tutorEmail', TextType::class, [
                    'label' => 'Correo institucional:',
                    'mapped' => false
                ]);

                $form->add('grupalProject', ChoiceType::class, array(
                    'choices' => array(
                        'No' => '0',
                        'Si' => '1',
                    ),
                    'data' => $projectRequest->getGrupalProject() ? $projectRequest->getGrupalProject() : '0',
                    'expanded' => true,
                    'label' => '¿Es un proyecto de trabajo final de graduación grupal?',
                   
                ));

                  $form->add('ascriptionUnit', TextType::class, [
                    'label' => 'Unidad de adscripción del proyecto:',
                    'required' => false,
                ]);

                $form->add('ucrInstitutions', TextareaType::class, [
                    'attr' => ['class' => 'tinymce', 'rows' => '4'],
                    'label' => 'Otras unidades o instituciones de la UCR participantes:',
                    'required' => false,
                ]);
              }

              $form->add('docHumanInformationFiles', FileType::class, array('multiple' => true, 'mapped' => false, 'required' => $data, 'label' => 'Acta de la comisión científica o de la Comisión de TFG de grado o posgrado:'));
              $form->add('extInstitutionsAuthorizationFiles', FileType::class, array('multiple' => true, 'mapped' => false, 'required' => $data, 'label' => false));
              $form->add('involvesHumans', ChoiceType::class, array(
                  'choices' => array(
                      'No' => '0',
                      'Si' => '1',
                  ),
                  'data' => $projectRequest->getInvolvesHumans() ? $projectRequest->getInvolvesHumans() : '0',
                  'expanded' => true,
                  'label' => 'La investigación involucra participantes humanos:',
              ));
              $form->add('docHumanInformation', ChoiceType::class, array(
                  'choices' => array(
                      'No' => '0',
                      'Si' => '1',
                  ),
                  'data' => $projectRequest->getDocHumanInformation() ? $projectRequest->getDocHumanInformation() : '0',
                  'expanded' => true,
                  'label' => 'La investigación requiere revisar información documental de seres humanos:',
              ));
              $form->add('extInstitutionsAuthorization', ChoiceType::class, array(
                  'choices' => array(
                      'No' => '0',
                      'Si' => '1',
                  ),
                  'data' => $projectRequest->getExtInstitutionsAuthorization() ? $projectRequest->getExtInstitutionsAuthorization() : '0',
                  'expanded' => true,
                  'label' => 'Autorización de la institución externa pública o privada:',
                  'attr' => ['class' => 'extInstitutionsAuthorization'],
                  'required' => true
              ));
              $form->add('involvesHumans', ChoiceType::class, array(
                  'choices' => array(
                      'No' => '0',
                      'Si' => '1',
                  ),
                  'data' => $projectRequest->getInvolvesHumans() ? $projectRequest->getInvolvesHumans() : '0',
                  'expanded' => true,
                  'label' => 'Acta de la comisión de trabajos finales de graduación:',
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

    if (!$projectRequest || null === $projectRequest->getId()) {
      $data = true;
    } else {
      $data = false;
    }
    $builder->add('docHumanInformationFiles', FileType::class, array('multiple' => true, 'mapped' => false, 'required' => $data, 'label' => 'Acta de la comisión científica o de la Comisión de TFG de grado o posgrado:'));
    $builder->add('extInstitutionsAuthorizationFiles', FileType::class, array('multiple' => true, 'mapped' => false, 'required' => $data, 'label' => false));
  }

}
