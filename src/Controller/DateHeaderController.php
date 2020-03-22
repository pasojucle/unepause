<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\DateLine;
use App\Entity\DateHeader;
use App\Form\DateHeaderType;
use App\Repository\DateHeaderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DateHeaderController extends AbstractController
{
    /**
     * @Route("/admin", name="date_header_list")
     */
    public function list(DateHeaderRepository $dateHeaderRepository) 
    {
        $dateHeaders = $dateHeaderRepository->findAll();

        return $this->render('date_header/list.html.twig', [
            'dateHeaders' => $dateHeaders,
        ]);
    }
    
    /**
     * @Route("/admin/dateHeader/add", name="date_header_add", options={"expose"=true})
     */
    public function add(EntityManagerInterface $manager, Request $request, ?DateHeader $dateHeader)
    {
        $dateHeader = new DateHeader();
        $dateHeader->addDateLine(new DateLine());

        $form = $this->createForm(DateHeaderType::class, $dateHeader);
        $form->handleRequest($request);
        $dateHeader = $form->getData();

        if ($request->isXmlHttpRequest()) {
            $unit = $dateHeader->getUnit();
            if (null != $unit) {
                $dateLines = $dateHeader->getDateLines()->toArray();
                $currentCount = count($dateLines);
                $count = $unit->getDateLineCount();

                if ($currentCount < $count) {
                    for ($i = $currentCount; $i < $count; $i++) {
                        $dateHeader->addDateLine(new DateLine());
                    }
                }
                if ($currentCount > $count) {
                    while ($currentCount > $count) {
                        $currentCount--;
                        $dateHeader->removeDateLine($dateLines[$currentCount]);
                    }
                }
            }
            $form = $this->createForm(DateHeaderType::class, $dateHeader);
        }

        if (!$request->isXmlHttpRequest() && $form->isSubmitted() && $form->isValid()) {
            foreach ($dateHeader->getDateLines() as $dateLine) {
                $dateLine->setDateHeader($dateHeader);
            }
            $manager->persist($dateHeader);
            $manager->flush();

            return $this->redirectToRoute('date_header_list');
        }

        return $this->render('date_header/add.html.twig', [
            'form' => $form->createView(),
            'dateHeaderId' => (null !== $dateHeader) ? $dateHeader-> getId() : null,
        ]);
    }

    /**
     * @Route("/admin/dateHeader/{dateHeader}", name="date_header_edit", defaults ={"dateHeader": null}, options={"expose"=true})
     */
    public function edit(EntityManagerInterface $manager, Request $request, ?DateHeader $dateHeader)
    {
        $bookings = $manager->getRepository(Booking::class)->findByDateHeader($dateHeader);
        return $this->render('date_header/edit.html.twig', [
            'dateHeader' => $dateHeader,
            'bookings' => $bookings,
        ]);
    }
}
