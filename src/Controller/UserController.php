<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\BookingRepository;
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

    /**
     * @Route("/user/account/{user}/{send}", name="user_account", defaults={"send": 0})
     */
    public function userAccount(BookingRepository $bookingRepository, User $user, int $send)
    {
        $bookings = $bookingRepository->findBy([
            'user' => $user->getId(),
        ]);
        
        if (1 == $send) {
            $this->addFlash(
                'success',
                'Votre demande à bien été envoyée !'
            );
        } else {
            $this->addFlash(
                'warning',
                'une erreure s\'est produite. Essayez à nouveau !'
            );
        }

        return $this->render('user/account.html.twig', [
            'user' => $user,
            'bookings' => $bookings,
        ]);
    }
}
