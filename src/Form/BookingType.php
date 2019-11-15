<?php

namespace App\Form;

use App\DateTime\DateTimeFrench;
use App\Entity\Product;
use App\Entity\TimeLine;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('timeLine', EntityType::class, [
                'class' => TimeLine::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('tl')
                        ->orderBy('tl.day', 'ASC');
                },
                'choice_label' => function ($timeLine) {
                    return $timeLine->getDay()->format('l j F Y \d\e H\hi')
                            .' à '.$timeLine->getDayEnd()->format('H\hi');
                },
                'expanded' => true,
                'multiple' => false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
