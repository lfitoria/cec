<?php

namespace App\Form;

use App\Entity\ExtraInformationRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExtraInformationRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tutorName')
            ->add('tutorId')
            ->add('tutorEmail')
            ->add('grupalProject')
            ->add('request')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExtraInformationRequest::class,
        ]);
    }
}
