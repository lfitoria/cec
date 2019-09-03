<?php

namespace App\Form;

use App\Entity\LdapUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LdapUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('username')
            ->add('name')
            ->add('password')
            ->add('external')
            ->add('lastLoginDate')
            ->add('creationDate')
            ->add('deletionDate')
            ->add('carnet')
            ->add('cedula_usuario')
            ->add('role')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LdapUser::class,
        ]);
    }
}
