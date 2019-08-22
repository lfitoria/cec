<?php

namespace App\Form;

use App\Form\FilesType;
use App\Entity\EthicEvalRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\Criterion;
use App\Repository\CriterionRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EthicEvalRequestType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
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
            ->add('amountParticipants', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '4'],
                'help' => 'Máximo 1000 caracteres.',
                'label' => 'Cantidad de participantes necesaria para lograr los objetivos, determinación estadística o justiﬁcación teórica',
                'required' => false,
            ])
            ->add('inExCriteria', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '4'],
                'help' => 'Máximo 1500 caracteres.',
                'label' => 'Criterios de inclusión y exclusión:',
                'required' => false,
            ])
            ->add('recruitmentParticipants', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '4'],
                'help' => 'Máximo 1500 caracteres.',
                'label' => 'Reclutamiento de los participantes (indicar cómo, quién, y cuándo se hará):',
                'required' => false,
            ])
            ->add('collectionInformation', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '4'],
                'help' => 'Máximo 1500 caracteres.',
                'label' => 'Recolección de información. Análisis de laboratorio, imágenes, pruebas psicológicas, cuestionarios, entrevistas u otros medios para generar datos o colectar información (Si aplica)',
                'required' => false,
            ])
            ->add('riskDeclaration', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '4'],
                'help' => 'Máximo 1000 caracteres.',
                'label' => 'Declaración de riesgos de la investigación',
                'required' => false,
            ])
            ->add('benefitsForParticipant', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '4'],
                'help' => 'Máximo 500 caracteres.',
                'label' => 'Beneﬁcios para la población:',
                'required' => false,
            ])
            ->add('benefitsForPopulation', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '4'],
                'help' => 'Máximo 500 caracteres.',
                'label' => 'Beneﬁcios para el participante individual:',
                'required' => false,
            ])
            ->add('previsionsPrivacy', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '4'],
                'help' => 'Máximo 500 caracteres.',
                'label' => 'Previsiones para resguardar la privacidad, conﬁdencialidad y almacenamiento de los datos, tiempo de resguardo, detalle de la anonimización de los datos de los participantes:',
                'required' => false,
            ])
            ->add('futureUse', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '4'],
                'help' => 'Máximo 500 caracteres.',
                'label' => ' Indique el uso futuro de las muestras biológicas y de los datos del participante:',
                'required' => false,
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
              $ethicEvalRequest = $event->getData();
              $form = $event->getForm();

              if (!$ethicEvalRequest || null === $ethicEvalRequest->getId()) {
                $informedConsent = '0';
                $informedAssent = '0';
              } else {
                $informedConsent = $ethicEvalRequest->getInformedConsent();
                $informedAssent = $ethicEvalRequest->getInformedAssent();
              }

              $form->add('informedConsent', ChoiceType::class, array(
                  'choices' => array(
                      'No' => '0',
                      'Si' => '1',
                  ),
                  'data' => $informedConsent,
                  'expanded' => true,
                  'label' => 'Requiere consentimiento informado:',
                  'help' => 'Esto aplica para las personas mayores de edad y los padres o representantes legales de menores de edad o de personas con capacidades cognitivas disminuidas.'));
              $form->add('informedAssent', ChoiceType::class, array(
                  'choices' => array(
                      'No' => '0',
                      'Si' => '1',
                  ),
                  'data' => $informedAssent,
                  'expanded' => true,
                  'label' => 'Requiere asentimiento informado:',
                  'help' => 'Esto aplica para las personas de doce a dieciocho años de edad.'));
            })
            ->add('informedConsentFiles', CollectionType::class, [
                  'entry_type' => FileType::class,
                  'entry_options' => ['label' => false],
                  'mapped' => false,
                  'allow_add' => true,
                  'required' => false,
                  'label' => false
            ])
            ->add('informedAssentFiles', CollectionType::class, [
                  'entry_type' => FileType::class,
                  'entry_options' => ['label' => false],
                  'mapped' => false,
                  'allow_add' => true,
                  'required' => false,
                  'label' => false
            ])
            ->add('collectionInformationFiles', CollectionType::class, [
                'entry_type' => FileType::class,
                'entry_options' => ['label' => false],
                'mapped' => false,
                'allow_add' => true,
                'required' => false,
                'label' => false
            ])
            ->add('population', EntityType::class, [
                'class' => Criterion::class,
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function(CriterionRepository $repo) {
                  return $repo->createPopulationQueryBuilder('population');
                },
                'label' => 'Participación de población vulnerable:',
                'help' => '(Marque todas las opciones que sean necesarias)'
            ])
            ->add('dataType', EntityType::class, [
                'class' => Criterion::class,
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function(CriterionRepository $repo) {
                  return $repo->createPopulationQueryBuilder('dataType');
                },
                'label' => 'Indicar qué tipos de datos se recopilarán en la investigación y marcar los que aplican:'
    ]);
  }

  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults([
        'data_class' => EthicEvalRequest::class,
    ]);
  }

}
