<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Car;
use App\Entity\Refueling;
use App\Form\Type\CarType;
use App\Form\Type\RefuelingType;
use App\Repository\CarRepository;
use App\Repository\RefuelingRepository;
use App\Repository\UserRepository;
use App\Service\RefuelingService;
use Doctrine\ORM\Mapping\Id;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class RefuelingController extends AbstractController
{
    #[Route('/refueling/add/{id}', name: 'refueling_add', defaults: ['_format' => 'html'], methods: ['POST','GET'])]
    public function addRefueling(int $id, Request $request, RefuelingService $refuelingService, RefuelingRepository $refuelingRepository, CarRepository $carRepository): Response
    {   
       

        $refueling=new Refueling();
        $form = $this->createForm(RefuelingType::class, $refueling);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) 
        {
            try {
                $refuelingService->addRefueling($refueling, $id);
                $this->addFlash('success', 'Pomyślnie dodano tankowanie!');
                return $this->redirectToRoute('app_refueling', [
                    'id' => $id
                ]);
            } catch (Exception $e){
                $this->addFlash('warning', $e->getMessage());
            }
        }
        
        return $this->render('refueling/add.html.twig', [
            'refuelingAdd'=>$form->createView(),
        ]);      
    }
    
    #[Route('/refueling/{carId}/delete/{id}', name: 'refueling_delete', methods: ['POST', 'GET'])]
    public function delete(int $carId, Request $request, Refueling $refueling, RefuelingService $refuelingService): Response
    {
        if ($this->isCsrfTokenValid('delete'.$refueling->getRefuelingId(), $request->request->get('_token'))) {
            $refuelingService->deleteRefueling($refueling);
        }
       
        $this->addFlash('success', 'Usunięto tankowanie!');

        return $this->redirectToRoute('app_refueling', [
            'id' => $carId
        ]);
    }
}