<?php

namespace App\Form;

use App\Entity\Job;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('avatar', FileType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Avatar'
                ],])
            ->add('firstname', TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prénom'
                ],])
            ->add('lastname', TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom'
                ],])
            ->add('username', TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Pseudo'
                ],])
            ->add('description', TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Description'
                ],])
            ->add('companyname', TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom de l\'entreprise'
                ],])
            ->add('birthdate', BirthdayType::class, [
                'widget' => 'choice',
                'label' => 'Date anniversaire',
            ])
            ->add('phonenumber', TelType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Numéro de téléphone'
                ],])
            ->add('email', EmailType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Email'
                ],])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options'  => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Mot de passe'
                    ]
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Vérifier le mot de passe'
                    ]
                ],
                'attr' => [
                    'placeholder' => 'Mot de passe'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Accepter les conditions générales d\'utilisation',
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}