<?php

namespace App\Controller\Admin;

use App\Entity\DateLine;
use App\Form\DateLineType;
use App\Repository\DateLineRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DateLineController extends AbstractController
{
    /**
     * @Route("/admin/timelines/", name="time_line_list")
     */
    public function timeLineList(DateLineRepository $dateLineRepository) 
    {
        $timeLines = $dateLineRepository->findAll();

        return $this->render('Admin/time_line/list.html.twig', [
            'timeLines' => $timeLines,
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
