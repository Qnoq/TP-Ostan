<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('avatar')
            // ->add('firstname')
            // ->add('lastname')
            // ->add('username')
            // ->add('companyname')
            // ->add('description')
            // ->add('siret')
            // ->add('password')
            // ->add('birthdate')
            // ->add('email')
            // ->add('address')
            // ->add('phonenumber')
            // ->add('createdAt')
            // ->add('updatedAt')
            // ->add('role')
            ->add('jobs', null, [
                'help' => 'Choix multiple possible',
                'label' => 'Rechercher par métiers :'
            ])
            ->add('tags', null, [
                'help' => 'Choix multiple possible',
                'label' => 'et par tags :'
            ]);
            // ->add('status')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
