<?php

namespace App\Form;

use App\Entity\LdapUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use App\Repository\UsersRolesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\UsersRoles;

use App\Entity\Criterion;
use App\Repository\CriterionRepository;

class LdapUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('email', TextType::class, [
                'label' => false
            ])
            ->add('username')
            ->add('name')
            // ->add('password')
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => false),
                'second_options' => array('label' => false),
            ))
            ->add('external', ChoiceType::class, array(
                'choices' => array(
                    'No' => '0',
                    'Sí' => '1',
                ),
                'expanded' => true,
                'label' => false,
            ))

            // ->add('lastLoginDate')
            // ->add('creationDate')
            // ->add('deletionDate')
            ->add('carnet')
            ->add('cedula_usuario')
            // ->add('role')
            // ->add('role', TextType::class, [
            //     'mapped' => false,
            // ]);
            ->add('role', EntityType::class, [
                'class' => UsersRoles::class,
                'multiple' => false,
                'expanded' => true,
                
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LdapUser::class,
        ]);
    }
}
