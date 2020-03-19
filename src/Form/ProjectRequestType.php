<?php

namespace App\Form;

use App\Form\FilesType;
use App\Form\TeamWorkType;
use App\Entity\ProjectRequest;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\Security;
use App\Entity\Criterion;
use App\Repository\CriterionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProjectRequestType extends AbstractType {

  protected $user;

  public function __construct(Security $security) {
    $this->user = $security->getUser();
  }

  public function buildForm(FormBuilderInterface $builder, array $options) {



    $builder
            ->add('extInstitutions', TextareaType::class, [
                'attr' => ['class' => 'tinymce', 'rows' => '4'],
                // 'label' => 'Otras instituciones externas públicas o privadas:',
                'label' => false,
                'required' => false
            ])
            ->add('placeOfStudy', TextareaType::class, [
                'attr' => ['class' => 'tinymce', 'rows' => '4'],
                // 'label' => 'Lugar donde se realizará el estudio (indique la ubicación geográfica).',
                'label' => false,
                'required' => false
            ])
            ->add('form_target_input', HiddenType::class, [
                'attr' => ['class' => 'form_target_input'],
                'required' => false,
                'mapped' => false
            ])
            ->add('extInstitutionsAuthorizationFiles', CollectionType::class, [
                'entry_type' => FileType::class,
                'entry_options' => ['label' => false],
                'mapped' => false,
                'allow_add' => true,
                'required' => true,
                'label' => false
            ])
            ->add('categoryBiomedicaFiles', CollectionType::class, [
                'entry_type' => FileType::class,
                'entry_options' => ['label' => false],
                'mapped' => false,
                'allow_add' => true,
                'required' => true,
                'label' => false
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
            ->add('uacademica', TextType::class, [
                'attr' => ['readonly' => true, 'class'=> 'd-none'],
                'label' => false,
                'required' => false,
                'mapped' => false,
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

              $form->add('extInstitutionsAuthorization', ChoiceType::class, array(
                  'choices' => array(
                      'No' => '0',
                      'Sí' => '1',
                  ),
                  'data' => $projectRequest->getExtInstitutionsAuthorization() ? $projectRequest->getExtInstitutionsAuthorization() : '0',
                  'expanded' => true,
                  'label' => 'Autorización de la institución externa pública o privada:',
                  'attr' => ['class' => 'extInstitutionsAuthorization'],
                  'required' => true
              ));
              
            $form->add('disable_question_extInstitutions', CheckboxType::class, array(
                    
                'attr' => ['class'=> 'd_disable_question'],
                'label' => 'No aplica',
                'required' => false,
                'mapped' => false,
            ));
            $form->add('disable_question_place', CheckboxType::class, array(
                    
                'attr' => ['class'=> 'd_disable_question'],
                'label' => 'No aplica',
                'required' => false,
                'mapped' => false,
            ));

              $userType = $this->user->getRole()->getDescription();
              if ($userType === "ROLE_STUDENT") {
                $form->add('disable_question_ucrInstitutions', CheckboxType::class, array(
                    
                    'attr' => ['class'=> 'd_disable_question'],
                    'label' => 'No aplica',
                    'required' => false,
                    'mapped' => false,
                ));
                $form->add('title', TextType::class, [
                    'label' => 'Titulo del proyecto:',
                ]);
                $form->add('tutorName', TextType::class, [
                    'label' => 'Nombre del tutor:',
                    'required' => false,
                ]);

                // $form->add('tutorId', TextType::class, [
                //     'label' => 'Cédula:',
                //     'required' => false
                // ]);
                $form->add('tutorEmail', TextType::class, [
                    'label' => 'Correo institucional:',
                    'required' => false
                ]);
                /*
                  $form->add('teamWork', CollectionType::class, [
                  'entry_type' => TeamWorkType::class,
                  'entry_options' => ['label' => false],
                  'allow_add' => true,
                  ]);
                 */
                $form->add('grupalProject', ChoiceType::class, array(
                    'choices' => array(
                        'No' => '0',
                        'Sí' => '1',
                    ),
                    'data' => $projectRequest->getGrupalProject() ? $projectRequest->getGrupalProject() : '0',
                    'expanded' => true,
                    'label' => '¿Es un proyecto de trabajo final de graduación grupal?',
                ));

                $form->add('ascriptionUnit', TextType::class, [
                    'label' => 'Unidad de adscripción del proyecto:',
                    'required' => false,
                ]);
                // $form->add('ascriptionUnit', ChoiceType::class, array(
                //     'choices' => array(
                //         'No' => '0',
                //         'Sí' => '1',
                //     ),
                    
                //     'expanded' => false,
                //     'label' => 'Unidad de adscripción del proyecto:',
                // ));
                

                $form->add('ucrInstitutions', TextareaType::class, [
                    'attr' => ['class' => 'tinymce', 'rows' => '4'],
                    // 'label' => 'Otras unidades o instituciones de la UCR participantes:',
                    'label' => false,
                    'required' => false,
                ]);

                $form->add('minuteFinalWork', ChoiceType::class, array(
                    'choices' => array(
                        'No' => '0',
                        'Sí' => '1',
                    ),
                    'data' => $projectRequest->getMinuteFinalWork() ? $projectRequest->getMinuteFinalWork() : '0',
                    'expanded' => true,
                    'label' => 'Acta de la comisión de trabajos finales de graduación:',
                ));

                $form->add('minuteFinalWorkFiles', CollectionType::class, [
                    'entry_type' => FileType::class,
                    'entry_options' => ['label' => false],
                    'mapped' => false,
                    'allow_add' => true,
                    'required' => true,
                    'label' => false
                ]);

                $form->add('minutesResearchCenter', ChoiceType::class, array(
                    'choices' => array(
                        'No' => '0',
                        'Sí' => '1',
                    ),
                    'data' => $projectRequest->getMinutesResearchCenter() ? $projectRequest->getMinutesResearchCenter() : '0',
                    'expanded' => true,
                    'label' => 'Acta de la comisión científica del instituto o centro de investigaciones:',
                ));

                $form->add('minutesResearchCenterFiles', CollectionType::class, [
                    'entry_type' => FileType::class,
                    'entry_options' => ['label' => false],
                    'mapped' => false,
                    'allow_add' => true,
                    'required' => true,
                    'label' => false
                ]);
              } else {
                $form->add('title', TextType::class, [
                    'attr' => ['readonly' => true, 'class'=> 'project_title_researcher','id'=>'project_title'],
                    'label' => 'Título del estudio o investigación:',
                ]);

                $form->add('projectUnit', TextType::class, [
                    'attr' => ['readonly' => true,'id'=>'project_request_projectUnit'],
                    'label' => 'Unidad base del proyecto:',
                ]);
                
               
                $form->add('minuteCommissionTFGFiles', CollectionType::class, [
                    'entry_type' => FileType::class,
                    'entry_options' => ['label' => false],
                    'mapped' => false,
                    'allow_add' => true,
                    'required' => true,
                    'label' => false
                ]);
              }





              $form->add('involvesHumans', ChoiceType::class, array(
                  'choices' => array(
                      'No' => '0',
                      'Sí' => '1',
                  ),
                  'data' => $projectRequest->getInvolvesHumans() ? $projectRequest->getInvolvesHumans() : '0',
                  'expanded' => true,
                  'label' => '¿La investigación involucra participantes humanos?',
              ));

              $form->add('docHumanInformation', ChoiceType::class, array(
                  'choices' => array(
                      'No' => '0',
                      'Sí' => '1',
                  ),
                  'data' => $projectRequest->getDocHumanInformation() ? $projectRequest->getDocHumanInformation() : '0',
                  'expanded' => true,
                  'label' => '¿La investigación requiere revisar información documental de seres humanos?',
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

}
