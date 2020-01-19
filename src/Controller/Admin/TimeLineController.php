<?php

namespace App\Controller\Admin;

use App\Entity\TimeLine;
use App\Form\TimeLineType;
use App\Repository\TimeLineRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TimeLineController extends AbstractController
{
    /**
     * @Route("/admin/timelines/", name="time_line_list")
     */
    public function timeLineList(TimeLineRepository $timeLineRepository) 
    {
        $timeLines = $timeLineRepository->findAll();

        return $this->render('Admin/time_line/list.html.twig', [
            'timeLines' => $timeLines,
        ]);
    }
    
    /**
     * @Route("/admin/timeline/{timeLine}", name="time_line_edit", defaults ={"timeLine": null}, options={"expose"=true})
     */
    public function timeLineEdit(ObjectManager $manager, Request $request, ?TimeLine $timeLine)
    {
        if (null === $timeLine) {
            $timeLine = new Timeline();
        }
        $form = $this->createForm(TimeLineType::class, $timeLine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
