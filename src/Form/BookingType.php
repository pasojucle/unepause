<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Booking;
use App\Entity\Product;
use App\Entity\DateHeader;
use App\Form\ApplicationType;
use App\DateTime\DateTimeFrench;
use App\Repository\PriceRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Repository\DateHeaderRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends ApplicationType
{
    private $dateHeaderRepo;
    private $priceRepo;

    public function __construct(DateHeaderRepository $dateHeaderRepo, PriceRepository $priceRepo){
        $this->dateHeaderRepo = $dateHeaderRepo;
        $this->priceRepo = $priceRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($builder->getData()->getProduct()->getType() == Product::SCHEDULE_SERVICE) {
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

        if (1 < count($options['dateHeaders'])) {
            $builder
            ->add('dateHeader', EntityType::class, [
                'class' => DateHeader::class,
                'choices' => $options['dateHeaders'],
                'choice_label' => function ($dateHeader) {
                    //return $dateHeader->getEditableDateLines();
                    return $dateHeader->getUnit()->getLabel();
                },
                'expanded' =>true,
                'multiple' => false,
                'block_prefix' => 'selectbox',
                'label' => 'Selectionner une date',
                'choice_attr' => function($choice, $key, $value){
                    $dateLines = $choice->getDateLines()->toArray();
                    $dateLinesArray = [];
                    foreach($dateLines as $dateLine) {
                        $date = new DateTimeFrench($dateLine->getDate()->format('Y-m-d H:i:s'));
                        $dateLinesArray[] = $date->format('l j M y à \p\a\r\t\i\r \d\e h:i');
                    }
                    return [
                        'data-date-lines' => serialize($dateLinesArray),
                    ];

                },
            ]);
        }

        $formModifier = function (FormInterface $form, DateHeader $dateHeader = null) use ($options) {
            //if(!empty($options['dateHeaders'])) {
                $availabilityQuantity = (null === $dateHeader) ? 0 : $this->dateHeaderRepo->findAvailabitityQuantity($dateHeader);
                $form
                ->add('quantity', ChoiceType::class, [
                    'choices' => range(1, $availabilityQuantity),
                    'choice_label' => function ($choice, $key, $value) {
                        return $value;
                    },
                ]);
            //}
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                $dateHeader =  (null !== $data) ? $data->getDateHeader() : null;
                $formModifier($event->getForm(), $dateHeader);
            }
        );

        $builder->get('dateHeader')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $dateHeader = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $dateHeader);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'dateHeaders' => [],
        ]);
    }
}
