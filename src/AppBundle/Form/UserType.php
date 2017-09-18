<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Description of Registration
 *
 * @author ealesfi
 */
class UserType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array('attr' => array('placeholder' => 'Your username'),
                'constraints' => array(
                    new NotBlank(array("message" => "Please provide a username")),
                )
            ))
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'Your email address'),
                'constraints' => array(
                    new NotBlank(array("message" => "Please provide a valid email")),
                    new Email(array("message" => "Your email doesn't seems to be valid")),
                )
            ))
            ->add('password', PasswordType::class, array('attr' => array('placeholder' => 'Your password'),
                'constraints' => array(
                    new NotBlank(array("message" => "Please provide a valid password")),
                )
            ))  
            ->add('save', SubmitType::class, array('label' => 'Submit'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class, // maps From to Entity
            'error_bubbling' => true
        ));
    }
}
