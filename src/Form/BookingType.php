<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Booking;
use App\Entity\Product;
use App\Entity\DateHeader;
use App\Form\ApplicationType;
use App\Service\BookingService;
use App\DateTime\DateTimeFrench;
use App\Repository\PriceRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Repository\DateHeaderRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\EventListener\AddQuantityFieldListener;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends ApplicationType
{
    private $dateHeaderRepo;
    private $priceRepo;
    private $bookingService;

    public function __construct(DateHeaderRepository $dateHeaderRepo, PriceRepository $priceRepo, BookingService $bookingService){
        $this->dateHeaderRepo = $dateHeaderRepo;
        $this->priceRepo = $priceRepo;
        $this->bookingService = $bookingService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $booking = $builder->getData();
        if ($booking->getProduct()->getType() == Product::SCHEDULE_SERVICE) {
            $commentsPlacehoder = 'Possez vous questions...';
        } else {
            $commentsPlacehoder = 'Donnez-moi vous disponniblités et je vous recontacte pour fixer le rendez-vous';
        }
        $availabilityQuantity = (null === $booking->getDateHeader()) ? 0 : $this->dateHeaderRepo->findAvailabitityQuantity($booking->getDateHeader());
        $price = $this->bookingService->getPrice($booking);
        dump($price);
        $builder
            ->add('comments', TextareaType::class, [
                'label_attr' => [
                    'class' => 'hidden',
                ],
                'required' => false,
                'attr' => [
                    'placeholder' => $commentsPlacehoder,
                ]
            ])
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
                    $data = $choice->getLongDateLines();
                    $dateLinesArray = [];
                    foreach($data['dateLines'] as $dateLine) {
                        $dateLinesArray[] = $dateLine;
                    }
                    return [
                        'data-date-lines' => serialize($dateLinesArray),
                    ];

                },
            ])
            ->add('quantity', ChoiceType::class, [
                'choices' => range(1, $availabilityQuantity),
                'choice_label' => function ($choice, $key, $value) {
                    return $value;
                },
            ]);
            if (null !== $price) {
                $builder
                ->add('price', HiddenType::class, [
                    'data' => $price,
                ])
                ;
            }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'dateHeaders' => [],
        ]);
    }
}
