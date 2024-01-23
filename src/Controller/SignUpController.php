<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignUpType;
use App\Repository\UserRepository;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class SignUpController extends AbstractController
{
    #[Route('/sign_up', name: 'signUp', defaults: ['_format' => 'html'], methods: ['POST', 'GET'])]
    //#[Route('/sign_up', name: 'app_login')]
    public function register(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, EmailService $emailService)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(SignUpType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );

            // 4) save the User!
            $user = $form->getData();
            $userRepository->addUser($user);
            $emailService->registrationConfirmation($form->get('email')->getData());

            return $this->redirectToRoute('app_login');
        }

        return $this->render('signUp/index.html.twig', [
            'register'=>$form->createView()
        ]);      

    }
}