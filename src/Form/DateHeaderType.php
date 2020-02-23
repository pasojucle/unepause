<?php

namespace App\Form;

use App\Entity\Unit;
use App\Entity\Product;
use App\Entity\DateHeader;
use App\Form\DateLineType;
use App\Repository\UnitRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class DateHeaderType extends AbstractType
{
    private $unitRepo;

    public function __construct(UnitRepository $unitRepo){
        $this->unitRepo = $unitRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $product = $builder->getData()->getProduct();
        $units = (null !== $product) ? $this->unitRepo->findByProduct($product) : null;

        $builder
            ->add('dateLines', CollectionType::class, [
                'entry_type' => DateLineType::class,
                'label' => 'Dates',
                'prototype' => true,
                'allow_add' => true,
            ])
            ->add('maxQuantity', NumberType::class, [
                'html5' => true,
                'label' => 'Nombre de personnes maximum',
                'attr' => [
                    'min' => 1,
                ],
            ])
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('p');
                    return  $qb->leftJoin('p.family', 'f')
                        ->where(
                            $qb->expr()->eq('p.isGeneric', 0),
                            $qb->expr()->eq('p.type', ':schedule_service')
                        )
                        ->setParameter(':schedule_service', Product::SCHEDULE_SERVICE)
                        ->orderBy('p.family', 'ASC')
                        ->addOrderBy('p.orderBy' ,'ASC');
                },
                'choice_label' => 'title',
                'placeholder' => 'choisir un produit',
                'group_by' => function($choice, $key, $value) {
                    return $choice->getFamily()->getName();
                },
                'label' => 'Produit',
            ])
            ->add('unit', EntityType::class, [
                    'class' => Unit::class,
                    'choices' => $units,
                    'choice_label' => 'label',
                    'label' => 'Unité',
                    'placeholder' => 'Choisir une unité',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DateHeader::class,
            //'allow_extra_fields' => true,
            //'csrf_protection'  => false,
        ]);
    }
}
