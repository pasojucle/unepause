<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user/add", name="user_add")
     */
    public function userAdd(Request $request, ObjectManager $manager)
    {
        $userForm = $this->createForm(UserType::class, null, [
            'action' => $this->generateUrl('user_add'),
        ]); 
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $user = $userForm->getData();
            $manager->persist($user);
            $manager->flush();
        }

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
