<?php

namespace App\EventListener;

use App\Entity\Entrainement;
use App\Repository\EntrainementRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Event\CalendarEvent;

class FullCalendarListener
{
    private $entrainementRepository;
    private $router;

    public function __construct(
        EntrainementRepository $entrainementRepository,
        UrlGeneratorInterface $router
    ) {
        $this->entrainementRepository = $entrainementRepository;
        $this->router = $router;
    }

    public function loadEvents(CalendarEvent $calendar): void
    {
        $startDate = $calendar->getStart();
        $endDate = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change b.beginAt by your start date in your custom entity
        $entrainements = $this->entrainementRepository
            ->createQueryBuilder('entrainement')
            ->where('entrainement.beginAt BETWEEN :startDate and :endDate')
            ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
            ->setParameter('endDate', $endDate->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        foreach ($entrainements as $entrainement) {
            // this create the events with your own entity (here entrainement entity) to populate calendar
            $entrainementEvent = new Event(
                $entrainement->getTitle(),
                $entrainement->getBeginAt(),
                $entrainement->getEndAt() // If the end date is null or not defined, a all day event is created.
            );


            $entrainementEvent->setUrl(
                $this->router->generate('entrainement_show', [
                    'id' => $entrainement->getId(),
                ])
            );

            // finally, add the entrainement to the CalendarEvent for displaying on the calendar
            $calendar->addEvent($entrainementEvent);

        }

    }
}