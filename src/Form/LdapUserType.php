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
            
            ->add('email')
            ->add('username',TextType::class,[
                'required' => false,
            ])
            ->add('name',TextType::class,[
                'required' => false,
            ])
            // ->add('password')
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => false),
                'second_options' => array('label' => false),
                'required' => false,
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
            // ->add('carnet',[
            //     'required' => false,
            // ])
            ->add('cedula_usuario', TextType::class,[
                'required' => false,
            ])
            // ->add('role')
            // ->add('role', TextType::class, [
            //     'mapped' => false,
            // ]);
            //bueno abajo
            // ->add('role', EntityType::class, [
            //     'class' => UsersRoles::class,
            //     'multiple' => false,
            //     'expanded' => true,
                
            //     ])
            ->add('role', ChoiceType::class, array(
                'choices' => array(
                    'Administrador' => '1',
                    'Evaluador' => '4',
                ),
                'expanded' => true,
                'data' => '4',
                'label' => 'Rol:',
                'required' => true
            ));
            // $form->add('involvesHumans', ChoiceType::class, array(
            //     'choices' => array(
            //         'No' => '0',
            //         'Sí' => '1',
            //     ),
            //     'data' => $projectRequest->getInvolvesHumans() ? $projectRequest->getInvolvesHumans() : '0',
            //     'expanded' => true,
            //     'label' => '¿La investigación involucra participantes humanos?',
            // ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LdapUser::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
