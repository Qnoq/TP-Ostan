<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // récupérer l'url
        $url = ($_SERVER["REQUEST_URI"]);

        // construit un formulaire différent selon l'url, à partir de la meme Entité
        if($url == '/message/new'){
        
            $builder
                ->add('content', TextareaType::class ,array(
                    'attr' => array(
                        'placeholder' => 'Message..'
                    )
                ))
                //->add('createdAt')
                //->add('email')
                ->add('title', TextType::class, array(
                    'attr' =>array(
                        'placeholder' => 'Titre du message'
                    )
                ))
                // pour définir, avec menu déroulant, le destinataire du message
                ->add('userReceiver', EntityType::class,[
                    'class'=> User::class,
                    'expanded' =>false,
                    'multiple' =>false,
                ])
            ;
        }else {
            $builder
                ->add('content', TextareaType::class ,array(
                    'label' => false,
                    'attr' => array(
                        'placeholder' => 'Votre message'
                        
                    )
                ));
        };
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
