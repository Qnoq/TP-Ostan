<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'constraints' => new NotBlank,
                // pour surcharger la mise en forme du formulaire
                'attr' => ['class' => 'form-control-title']
            ])
            ->add('email', null, [
                'constraints' => new NotBlank,
                'attr' => ['class' => 'form-control-email']
            ])
            ->add('content', null, [
                'constraints' => new NotBlank,
                'attr' => ['class' => 'form-control-content']
            ])
            
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
            'attr' => ['novalidate' => 'novalidate'],
        ]);
    }
}
