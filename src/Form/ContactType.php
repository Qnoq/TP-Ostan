<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => false,
                'constraints' => new NotBlank,
                // pour surcharger la mise en forme du formulaire
                'attr' => [
                    'class' => 'form-control-title',
                    'placeholder' => 'Prénom'
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => false,
                'constraints' => new NotBlank,
                // pour surcharger la mise en forme du formulaire
                'attr' => [
                    'class' => 'form-control-title',
                    'placeholder' => 'Nom'
                ],
            ])
            ->add('phone', TelType::class, [
                'label' => false,
                'constraints' => new NotBlank,
                'attr' => [
                    'class' => 'form-control-email',
                    'placeholder' => 'Numéro de téléphone'
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'constraints' => new NotBlank,
                'attr' => [
                    'class' => 'form-control-email',
                    'placeholder' => 'Votre email'
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => false,
                'constraints' => new NotBlank,
                'attr' => [
                    'class' => 'form-control-content',
                    'placeholder' => 'Votre message'
                ],
            ])
            
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class
        ]);
    }
}
