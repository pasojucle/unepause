<?php

namespace App\Form;

use App\Entity\Unit;
use App\Entity\Product;
use App\Entity\TimeLine;
use App\Repository\UnitRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class TimeLineType extends AbstractType
{
    private $unitRepo;

    public function __construct(UnitRepository $unitRepo){
        $this->unitRepo = $unitRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('day', DateTimeType::class, [
                'html5' => true,
                'label' => 'Date',
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
            ]);


            $formModifier = function (FormInterface $form, Product $product = null) {
                
                $units = (null !== $product) ? $this->unitRepo->findByProduct($product) : null;
                $form->add('unit', EntityType::class, [
                    'class' => Unit::class,
                    'choices' => $units,
                    'choice_label' => 'label',
                    'label' => 'Unité',
                    'placeholder' => 'Choisir une unité',
                ]);
            };

            $builder->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use ($formModifier) {
                    $data = $event->getData();
                    $product =  (null !== $data) ? $data->getProduct() : null;
                    $formModifier($event->getForm(), $product);
                }
            );
    
            $builder->get('product')->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) use ($formModifier) {
                    $product = $event->getForm()->getData();
                    dump($product);
                    $formModifier($event->getForm()->getParent(), $product);
                }
            );
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TimeLine::class,
        ]);
    }
}
