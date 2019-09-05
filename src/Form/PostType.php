<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\File\File;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Titre de l\'annonce'
                ],])
            ->add('picture1', FileType::class, [
                'data_class' => null,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Image'
                ],])
            ->add('picture2', FileType::class, [
                'data_class' => null,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Image'
                ],])
            ->add('picture3', FileType::class, [
                'data_class' => null,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Image'
                ],])
            ->add('description', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Message'
                ],])
            // ->add('createdAt')
            // ->add('updatedAt')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Article' => true,
                    'Annonce' => false,
                ],])
            // ->add('user')
            // ->add('tags')
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