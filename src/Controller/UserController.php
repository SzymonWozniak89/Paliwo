<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user', defaults: ['_format' => 'html'], methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED')]
    public function index(UserRepository $userRepository): Response
    {
        $logged=$this->getUser();
        dd($logged);

        $test=$userRepository->findOneByUsername('sajmon6996@wp.pl');
        dd($test);
        
        return $this->render('user/index.html.twig', [
            'logged' => $logged           
        ]);
    }
    // #[Route('/user/{$id}', name: 'app_user', defaults: ['_format' => 'html'], methods: ['POST'])]
    // #[IsGranted('IS_AUTHENTICATED')]
    // public function getById(int $id, UserRepository $userRepository): Response
    // {
    //     $user=$userRepository->find($id);
    //     $logged=$this->getUser();
    //     return $this->render('user/index.html.twig', [
            
    //         'user' => ,
    //         'logged' => $logged
    //     ]);
    // }
}