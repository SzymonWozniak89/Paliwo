<?php
namespace App\Service;

use App\Entity\Car;
use App\Entity\PrintableInterface;
use App\Entity\User;
use App\Repository\CarRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;

class CarService{
    public function __construct(
        public readonly CarRepository $carRepository,
        public readonly Security $security,
        public readonly UserRepository $userRepository
        ){

    }

    public function getUserCars()
    {
        /** @var User $user */
        $user = $this->security->getUser();
        return $this->carRepository->findCarByUserId($user->getId());
    }

    public function fetchCar(int $id):Car
    {
        return $this->carRepository->findCarByCarId($id);
    }

    public function addNewCar(Car $car) 
    {
        /** @var User $user */
        $user=$this->security->getUser();
        if(!$user){
            $user = $this->userRepository->find($car->getUserId());
        }
        $car->setUser($user);
        $user->addCar($car);
        return $this->userRepository->addUser($user);
    }

    public function editCar($car)
    {
        return $this->carRepository->addCar($car);
    }

    public function deleteCar($car)
    {
       return $this->carRepository->remove($car);
    }

    public function getAllCars()
    {
        return $this->carRepository->findAll();
    }
}