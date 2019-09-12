<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $listener = function (FormEvent $event) {
            /*
                L'objet du type FormEvent contient deux methodes :
                - getData() qui permet de recuperer les données du formulaire
                - getForm() qui permet de recupèrer le formulaire en tant que tel
            */

            $user = $event->getData(); // entity passé en cours qui va servir au pre remplissage
            $form = $event->getForm(); //contient le formulaire concerné en cours de creation


            if(is_null($user->getId())){ //si mon user id est null = creation de l'utilisateur

                $form->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'options' => ['attr' => ['class' => 'password-field']],
                    'required' => true,
                    'label' => false,
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
                    'constraints'=> [
                        new NotBlank()
                    ]
                ]);

            } else { //sinon si je ne suis pas creation , c'est que mon user a un id donc que je suis en modification

                //j'ajoute au formulaire pendant l'evenement de remplissage des données mon champs password
                $form->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'options' => ['attr' => ['class' => 'password-field']],
                    'required' => true,
                    'first_options'  => [
                        'label' => 'Password',
                        'attr' => [
                            'placeholder' => 'Laissez vide si inchangé'
                        ]
                    ],
                    'second_options' => [
                        'label' => 'Repeat Password',
                        'attr' => [
                            'placeholder' => 'Laissez vide si inchangé'
                        ]
                    ],
                ]);
            }
            
        };
        
        $builder
            ->add('avatar', FileType::class, [
                'data_class' => null,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Image'
                ],])
            ->addEventListener(FormEvents::PRE_SET_DATA, $listener)
            ->add('firstname', TextType::class,['label' => 'Prénom'])
            ->add('lastname', TextType::class,['label' => 'Nom'])
            ->add('username', TextType::class,['label' => 'Pseudo'])
            ->add('companyname', TextType::class,['label' => 'Nom de l\'entreprise'])
            ->add('description', TextType::class,['label' => 'description'])
            ->add('birthdate', BirthdayType::class, [
                'widget' => 'choice',
            ])
            ->add('phonenumber')
            ->add('email', EmailType::class,['label' => 'Adresse email'])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
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
            //cet attribut permet de desactiver la validation HTML5
            //malgres le fait qu'il soit pratique, il est souvent demandé quelle soient desactivée pour que  l'intégration des messages d'erreurs prenne le pas sur ce que le navigateur propose
            'attr' => ['novalidate' => 'novalidate'] 
        ]);
    }
}
