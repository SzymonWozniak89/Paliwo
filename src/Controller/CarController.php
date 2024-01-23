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

class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car', defaults: ['_format' => 'html'], methods: ['GET'])]

    public function carList(CarService $carService): Response
    {    
        return $this->render('car/index.html.twig', [
            'cars' => $carService->getUserCars()
        ]);      
    }

    #[Route('/car/refueling/{id}', name: 'app_refueling', defaults: ['_format' => 'html'], methods: ['GET'])]
    public function refueling(int $id, RefuelingRepository $refuelingRepository, CarService $carService): Response
    {   
        /** @var Car $car */ 
        $car=$carService->fetchCar($id);

        return $this->render('refueling/index.html.twig', [
            'refuelings' => $car->getRefuelings(),
            'refuelingAvgFC' => $refuelingRepository->refuelingAvgFC($id),
            'refuelingAvgCost' => $refuelingRepository->refuelingAvgCost($id),
            'carId' => $id
        ]);      
    }

    #[Route('/car/add', name: 'car_add', defaults: ['_format' => 'html'], methods: ['POST','GET'])]
    public function addCar(Request $request, CarService $carService): Response
    {    
        $car=new Car(); 
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $carService->addNewCar($car);
            $this->addFlash('success', 'Pomyślnie dodano nowy samochód!');
            return $this->redirectToRoute('app_car');
        }
        return $this->render('car/add.html.twig', [
            'carAdd'=>$form->createView()
        ]);      
    }
    
    #[Route('/car/edit/{id}', name: 'car_edit', defaults: ['_format' => 'html'], methods: ['POST','GET'])]

    public function editCar(Car $car, Request $request, CarService $carService): Response
    {    
         $form = $this->createForm(CarType::class, $car, ['isEdit'=>true]);
         $form->handleRequest($request);
            
         if ($form->isSubmitted() && $form->isValid()) 
         {
             $carService->editCar($car);

             $this->addFlash('success', 'Zaktualizowano dane samochodu!');
             
             return $this->redirectToRoute('app_car');
         }

         return $this->render('car/edit.html.twig', [
             'carEdit' => $form->createView()
         ]);      
     }

     #[Route('/car/delete/{id}', name: 'car_delete', methods: ['POST'])]
     public function delete(Request $request, Car $car, CarService $carService): Response
     {
         if ($this->isCsrfTokenValid('delete'.$car->getCarId(), $request->request->get('_token'))) {
             $carService->deleteCar($car);
             $this->addFlash('success', 'Usunięto samochód!');
         }

         return $this->redirectToRoute('app_car');
     }


}

