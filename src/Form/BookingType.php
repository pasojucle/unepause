<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Booking;
use App\Entity\Product;
use App\Entity\TimeLine;
use App\Form\ApplicationType;
use App\Repository\PriceRepository;
use Symfony\Component\Form\FormEvent;
use App\Repository\TimeLineRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends ApplicationType
{
    private $timeLineRepo;
    private $priceRepo;

    public function __construct(TimeLineRepository $timeLineRepo, PriceRepository $priceRepo){
        $this->timeLineRepo = $timeLineRepo;
        $this->priceRepo = $priceRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($builder->getData()->getProduct()->getType() == Product::SHEDULE_SERVICE) {
            $commentsPlacehoder = 'Possez vous questions...';
        } else {
            $commentsPlacehoder = 'Donnez-moi vous disponniblités et je vous recontacte pour fixer le rendez-vous';
        }
        $builder
        ->add('price', HiddenType::class)
        ->add('comments', TextareaType::class, [
            'label_attr' => [
                'class' => 'hidden',
            ],
            'required' => false,
            'attr' => [
                'placeholder' => $commentsPlacehoder,
            ]
        ]); 
        if(!empty($options['timeLines'])) {
            $timeLine = $builder->getData()->getTimeLine();
            $availabilityQuantity = null === $timeLine ? 0 : $this->timeLineRepo->findAvailabitityQuantity($timeLine);
                if (1 < count($options['timeLines'])) {
                    $builder
                    ->add('timeLine', EntityType::class, [
                        'class' => TimeLine::class,
                        'choices' => $options['timeLines'],
                        'choice_label' => function ($timeLine) {
                            return $timeLine->getDay()->format('l j F Y \d\e H\hi')
                                    .' à '.$timeLine->getDayEnd()->format('H\hi');
                        },
                        'expanded' => false,
                        'multiple' => false,
                        'label' => 'Selectionner une date',
                    ]);
                }
dump($availabilityQuantity);
                $builder
                ->add('quantity', ChoiceType::class, [
                    'choices' => range(1, $availabilityQuantity),
                    'choice_label' => function ($choice, $key, $value) {
                        return $value;
                    },
                ])
            ;
            
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'timeLines' => [],
        ]);
    }
}
