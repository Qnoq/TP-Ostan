<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Titre'
                ],])
            ->add('picture1', FileType::class, [
                'data_class' => null,
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Image'
                ],])
            ->add('picture2', FileType::class, [
                'data_class' => null,
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Image'
                ],])
            ->add('picture3', FileType::class, [
                'data_class' => null,
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Image'
                ],])
            ->add('description', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Message',
                    'cols' => '5', 
                    'rows' => '5'
                ],])
            // ->add('createdAt')
            // ->add('updatedAt')
            //  ->add('type', ChoiceType::class, [
            //      'choices' => [
            //          'Article' => true,
            //          'Annonce' => false,
            //      ],])
            // ->add('user')
            ->add('tags', null, [
                'attr' => [
                    'class'=>'select-tags'
                ],
                'label_attr'=>[
                    'class'=>'label_select-tags'
                ]
            ])
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