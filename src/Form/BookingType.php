<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\TimeLine;
use App\Form\ApplicationType;
use App\DateTime\DateTimeFrench;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use App\Repository\TimeLineRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BookingType extends ApplicationType
{
    private $timeLineRepo;

    public function __construct(TimeLineRepository $timeLineRepo){
        $this->timeLineRepo = $timeLineRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if(!empty($options['timeLines'])) {

            $builder
                ->add('timeLine', EntityType::class, [
                    'class' => TimeLine::class,
                    'choices' => $options['timeLines'],
                    'choice_label' => function ($timeLine) {
                        return $timeLine->getDay()->format('l j F Y \d\e H\hi')
                                .' à '.$timeLine->getDayEnd()->format('H\hi');
                    },
                    //'data' => (null == $builder->getData()) ? $options['timeLines'][0] : $builder->getData()->getTimeLine(),
                    'expanded' => true,
                    'multiple' => false,
                ]);
            ;

            $formModifier = function (FormInterface $form, TimeLine $timeLine = null) {

                $availabilityQuantity = null === $timeLine ? 0 : $this->timeLineRepo->findAvailabitityQuantity($timeLine);
                dump($availabilityQuantity);
                $form->add('quantity', ChoiceType::class, [
                    'choices' => range(1, $availabilityQuantity),
                    'choice_label' => function ($choice, $key, $value) {
                        return $value;
                    }
                ]);
            };
    
            $builder->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use ($formModifier) {
                    $data = $event->getData();
                    $formModifier($event->getForm(), $data->getTimeLine());
                }
            );
    
            $builder->get('timeLine')->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) use ($formModifier) {
                    $timeLine = $event->getForm()->getData();
                    $formModifier($event->getForm()->getParent(), $timeLine);
                }
            );
        }
        $builder
            ->add('comments', 
                TextType::class, 
                $this->getConfiguration('Commentaires','Laissez vos commentaires, possez vous questions...', [
                    'required' => false,
                ])
            );
        

        

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'timeLines' => [],
        ]);
    }
}
