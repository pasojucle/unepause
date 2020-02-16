<?php

namespace App\Controller\Admin;

use App\Entity\DateLine;
use App\Form\DateLineType;
use App\Repository\DateHeaderRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DateHeaderController extends AbstractController
{
    /**
     * @Route("/admin/dateHeaders/", name="date_header_list")
     */
    public function dateHeaderList(DateHeaderRepository $dateHeaderRepository) 
    {
        $dateHeaders = $dateHeaderRepository->findAll();

        return $this->render('Admin/date_header/list.html.twig', [
            'dateHeaders' => $headers,
        ]);
    }
    
    /**
     * @Route("/admin/timeline/{timeLine}", name="time_line_edit", defaults ={"timeLine": null}, options={"expose"=true})
     */
    public function timeLineEdit(ObjectManager $manager, Request $request, ?DateLine $timeLine)
    {
        if (null === $timeLine) {
            $timeLine = new Dateline();
        }
        $form = $this->createForm(DateLineType::class, $timeLine);
        $form->handleRequest($request);

        if (false ==$request->isXmlHttpRequest() && $form->isSubmitted() && $form->isValid()) {
            $timeLine = $form->getData();
            $manager->persist($timeLine);
            $manager->flush();

            return $this->redirectToRoute('time_line_list');
        }

        return $this->render('Admin/time_line/edit.html.twig', [
            'form' => $form->createView(),
            'timeLineId' => (null !== $timeLine) ? $timeLine-> getId() : null,
        ]);
    }
}
