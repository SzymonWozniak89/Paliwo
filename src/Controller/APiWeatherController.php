<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Car;
use App\Entity\Car2;
use App\Entity\Car3;
use App\Form\Type\CarType;
use App\Form\Type\CarEditType;
use App\Repository\CarRepository;
use App\Repository\RefuelingRepository;
use App\Repository\UserRepository;
use App\Service\APiWeatherService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Service\CarService;

#[Route('/api', name: 'api_')]
class APiWeatherController extends AbstractController
{
    #[Route('/weather', name: 'weather', methods: ['GET'])]
    public function getAPiWeatherData(APiWeatherService $aPiWeatherService)
    {
        return $this->render('partials/weather.html.twig', [
            'weatherInfo'=>$aPiWeatherService->getWeather()
        ]); 
    }

}