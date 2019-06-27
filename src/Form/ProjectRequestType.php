<?php

namespace App\Form;

use App\Entity\ProjectRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('code')
            ->add('state')
            ->add('extInstitutions')
            ->add('extInstitutionsAuthorization')
            ->add('placeOfStudy')
            ->add('involvesHumans')
            ->add('docHumanInformation')
            ->add('projectUnit')
            ->add('users')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProjectRequest::class,
        ]);
    }
}
