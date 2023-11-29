<?php
namespace App\Service;

use App\Entity\Car;
use App\Entity\User;
use App\Repository\CarRepository;
use App\Repository\UserRepository;
use App\Repository\RefuelingRepository;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;


class RefuelingService{
    public function __construct(
        public readonly CarRepository $carRepository,
        public readonly UserRepository $userRepository,
        public readonly RefuelingRepository $refuelingRepository,
        public readonly Security $security
        ){

    }

    public function addRefueling($refueling, $id)
    {
        $arrErrors=[];
        /** @var CarRepository $carRepository */
        /** @var RefuelingRepository $refuelingRepository */
        $refuelingLiters = $refueling->getRefuelingLiters();
        $refuelingOdometer = $refueling->getRefuelingOdometer();
        $refuelingDate = $refueling->getRefuelingDate();

        //stan licznika z ostatniego tankowania
        //sprawdzenie czy jest minimum jedno tankowanie
        
        $testLastRefueling = $this->refuelingRepository->findLastOdometer($id);
        if ($testLastRefueling==null) {
            $lastRefuelingOdometer = $this->carRepository->findCarOdometer($id)->getCarOdometer();
        } else {
            $lastRefuelingOdometer = $testLastRefueling->getRefuelingOdometer();
            $lastRefuelingDate = $testLastRefueling->getRefuelingDate();
        }

        //sprawdzenie czy data tankowania jest wcześniejsza lub równa poprzedniej
        if ($refuelingDate < $lastRefuelingDate)
        {
            $arrErrors[]='Podana data jest wcześniejsza niż data ostatniego tankowania.';
        }
        //sprawdzenie czy stan licznika nie jest mniejszy od poprzedniego
        if ($refuelingOdometer <= $lastRefuelingOdometer){
            $arrErrors[]='Stan licznika mniejszy niż stan z ostatniego tankowania.';
        }            
        if (count($arrErrors)>=1){
            throw new Exception(implode("</br>",$arrErrors));
        }
              /** @var User $user */
            $user=$this->security->getUser();
            $car = $user->getCar($id);
            $refueling->setCar($car);
            $car->addRefueling($refueling);
                
            //średnie spalanie
            $AvgFC = round(($refuelingLiters/(($refuelingOdometer - $lastRefuelingOdometer)/100)),2);

            $refueling->setRefuelingAvgFuelConsumption($AvgFC);

            return $this->carRepository->addCar($car);
    }

    public function deleteRefueling($refueling)
    {
       return $this->refuelingRepository->remove($refueling);
    }
}