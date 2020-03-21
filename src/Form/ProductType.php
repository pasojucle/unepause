<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Contenu',
            ])
            ->add('orderBy', NumberType::class, [
                'label' => 'ordre',
            ])
            ->add('title', TextType::class, [

            ])
            ->add('type', ChoiceType::class, [
                'choices' => Product::PRODUCT_TYPES,
                'choice_label' => function ($choice, $key, $value) {
                    return $value;
                },
            ])
            ->add('summary', TextareaType::class, [
                'label' => 'Contenu',
            ])
            ->add('calendarEventColor', ColorType::class, [
                'label' => 'Couleur sur le calendrier',
            ])
            ->add('family', EntityType::class, [
                'label' => 'Famille',
                'class' => Product::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.family', 'ASC');
                },
                'choice_label' => 'title',
                'placeholder' => 'choisir une famille',
            ])
            ->add('images', EntityType::class, [
                'class' => Image::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('i')
                        ->orderBy('i.title', 'ASC');
                },
                'choice_label' => 'title',
                'label' => 'Images',
                'placeholder' => 'Choisir une image',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
