<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CarRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user', defaults: ['_format' => 'html'], methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED')]
    public function user(): Response
    {
         /**  @var User $logged */ 
        $logged=$this->getUser();
   
        return $this->render('user/index.html.twig', [
            'logged' => $logged,     
        ]);
    }

}