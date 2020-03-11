<?php

namespace App\EventSubscriber;

use CalendarBundle\Entity\Event;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Event\CalendarEvent;
use App\Repository\DateHeaderRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    private $dateHeaderRepository;
    private $router;

    public function __construct(DateHeaderRepository $dateHeaderRepository, UrlGeneratorInterface $router)
    {
        $this->dateHeaderRepository = $dateHeaderRepository;
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // You may want to make a custom query from your database to fill the calendar
        $dateHeaders = $this->dateHeaderRepository->findAll();

        if (null !== $dateHeaders) {
            foreach ($dateHeaders as $dateHeader) {
                $product = $dateHeader->getProduct();
                $dateLines = $dateHeader->getDateLines();
                if (!empty($dateLines)) {
                    foreach($dateHeader->getDateLines() as $dateLine)

                    $dateHeaderEvent = new Event(
                        $product->getFamily()->getShortName(),
                        $dateLine->getDate(),
                        $dateLine->getDateEnd() // If the end date is null or not defined, a all day event is created.
                    );

                    $dateHeaderEvent->setOptions([
                        'backgroundColor' => $product->getcalendarEventColor(),
                        'borderColor' => $product->getcalendarEventColor(),
                    ]);
                    $dateHeaderEvent->addOption(
                        'url',
                        $this->router->generate('date_header_edit', [
                            'dateHeader' => $dateHeader->getId(),
                        ])
                    );
        
                    $calendar->addEvent($dateHeaderEvent);
                }
            }
        }
    }
}