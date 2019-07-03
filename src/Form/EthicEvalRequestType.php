<?php

namespace App\Form;

use App\Entity\EthicEvalRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EthicEvalRequestType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('amountParticipants', TextareaType::class, [
                    'attr' => ['class' => 'form-control', 'rows' => '4'],
                    'help' => 'Máximo 1000 caracteres.',
                    'label' => 'Cantidad de participantes necesaria para lograr los objetivos, determinación estadística o justiﬁcación teórica',
                ])
                ->add('inExCriteria', TextareaType::class, [
                    'attr' => ['class' => 'form-control', 'rows' => '4'],
                    'help' => 'Máximo 1500 caracteres.',
                    'label' => 'Criterios de inclusión y exclusión:',
                ])
                ->add('recruitmentParticipants', TextareaType::class, [
                    'attr' => ['class' => 'form-control', 'rows' => '4'],
                    'help' => 'Máximo 1500 caracteres.',
                    'label' => 'Reclutamiento de los participantes (indicar cómo, quién, y cuándo se hará):',
                ])
                ->add('collectionInformation', TextareaType::class, [
                    'attr' => ['class' => 'form-control', 'rows' => '4'],
                    'help' => 'Máximo 1500 caracteres.',
                    'label' => 'Recolección de información. Análisis de laboratorio, imágenes, pruebas psicológicas, cuestionarios, entrevistas u otros medios para generar datos o colectar información (Si aplica)',
                ])
                ->add('riskDeclaration', TextareaType::class, [
                    'attr' => ['class' => 'form-control', 'rows' => '4'],
                    'help' => 'Máximo 1000 caracteres.',
                    'label' => 'Declaración de riesgos de la investigación',
                ])
                ->add('benefitsForParticipant', TextareaType::class, [
                    'attr' => ['class' => 'form-control', 'rows' => '4'],
                    'help' => 'Máximo 500 caracteres.',
                    'label' => 'Beneﬁcios para la población:',
                ])
                ->add('benefitsForPopulation', TextareaType::class, [
                    'attr' => ['class' => 'form-control', 'rows' => '4'],
                    'help' => 'Máximo 500 caracteres.',
                    'label' => 'Beneﬁcios para el participante individual:',
                ])
                ->add('previsionsPrivacy', TextareaType::class, [
                    'attr' => ['class' => 'form-control', 'rows' => '4'],
                    'help' => 'Máximo 500 caracteres.',
                    'label' => 'Previsiones para resguardar la privacidad, conﬁdencialidad y almacenamiento de los datos, tiempo de resguardo, detalle de la anonimización de los datos de los participantes:',
                ])
                ->add('futureUse', TextareaType::class, [
                    'attr' => ['class' => 'form-control', 'rows' => '4'],
                    'help' => 'Máximo 500 caracteres.',
                    'label' => ' Indique el uso futuro de las muestras biológicas y de los datos del participante:',
                ])
                ->add('informedConsent', ChoiceType::class, array(
                    'choices' => array(
                        'Sí' => 1,
                        'No' => 0,
                    ),
                    'expanded' => true,
                    'label' => 'Requiere consentimiento informado:'))
                ->add('informedAssent', ChoiceType::class, array(
                    'choices' => array(
                        'Sí' => 1,
                        'No' => 0,
                    ),
                    'expanded' => true))
                ->add('informedConsentFiles', FileType::class, array('multiple' => false, 'mapped' => false))
                ->add('informedAssentFiles', FileType::class, array('multiple' => false, 'mapped' => false));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => EthicEvalRequest::class,
        ]);
    }

}
