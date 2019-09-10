<?php

namespace App\Form;


use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdPostSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('title')
            // ->add('picture1')
            // ->add('picture2')
            // ->add('picture3')
            // ->add('description')
            // ->add('createdAt')
            // ->add('updatedAt')
            // ->add('type')
            // ->add('user')
            ->add('tags', null, [
                'help' => 'Choix multiple possible',
                'label' => 'Rechercher par tags :'
            ]);
            // ->add('status')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
