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
class APiController extends AbstractController
{
    #[Route('/cars', name: 'cars_index', methods: ['GET'])]
    public function getCars(CarService $carService): JsonResponse
    {
        $cars = $carService->getAllCars();
        $arrReturn = [];
        foreach ($cars as $car) 
        {
            $arrReturn[$car->getCarId()] = [
                'Brand'=>$car->getCarBrand(),
                'Model'=>$car->getCarModel(),
                'Odometer'=>$car->getCarOdometer()
            ];
        }        
        //dd($cars);
        return $this->json($arrReturn, 200);
    }

    #[Route('/cars', name: 'cars_post', methods: ['POST'])]
    public function postCars(Request $request, CarService $carService): JsonResponse
    {
        $params = json_decode($request->getContent(), TRUE);
        //dd($params);
        $car = new Car();
        $car->setUserId($params['userId']);
        $car->setCarBrand($params['Brand']);
        $car->setCarModel($params['Model']);
        $car->setCarFuel($params['Fuel']);
        $car->setCarOdometer($params['Odometer']);
        $carService->addNewCar($car);
        
        return $this->json([], 200);
    }



}