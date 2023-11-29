<?php

namespace App\Entity;

use App\Repository\RefuelingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RefuelingRepository::class)]
class Refueling
{
    use LoggableEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $refueling_id = null;

    #[ORM\Column]
    private ?int $car_id = null;

    #[ORM\ManyToOne(targetEntity: Car::class, inversedBy: 'refuelings', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'car_id', referencedColumnName: 'car_id')]
    private Car|null $car = null;

    #[ORM\Column]
    private ?int $refueling_odometer = null;

    #[ORM\Column]
    private ?float $refueling_liters = null;

    #[ORM\Column]
    private ?float $refueling_price = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $refueling_date = null;

    #[ORM\Column]
    private ?float $refueling_avg_fuel_consumption = null;

    // public function __construct(){
    //     $this->logActivity('dupa dupa 1');
    // }
    public function setCar(Car $car): self{
        $this->car=$car;
        return $this;
    }

    public function getCar($car_Id): Car {
        return $this->car;
    }

    public function getRefuelingId(): ?int
    {
        return $this->refueling_id;
    }

    public function getCarId(): ?int
    {
        return $this->car_id;
    }

    public function setCarId(int $car_id): static
    {
        $this->car_id = $car_id;

        return $this;
    }

    public function getRefuelingOdometer(): ?int
    {
        return $this->refueling_odometer;
    }

    public function setRefuelingOdometer(int $refueling_odometer): static
    {
        $this->refueling_odometer = $refueling_odometer;

        return $this;
    }

    public function getRefuelingLiters(): ?int
    {
        return $this->refueling_liters;
    }

    public function setRefuelingLiters(int $refueling_liters): static
    {
        $this->refueling_liters = $refueling_liters;

        return $this;
    }

    public function getRefuelingPrice(): ?float
    {
        return $this->refueling_price;
    }

    public function setRefuelingPrice(float $refueling_price): static
    {
        $this->refueling_price = $refueling_price;

        return $this;
    }

    public function getRefuelingDate(): ?\DateTimeInterface
    {
        return $this->refueling_date;
    }

    public function setRefuelingDate(\DateTimeInterface $refueling_date): static
    {
        $this->refueling_date = $refueling_date;

        return $this;
    }

    public function getRefuelingAvgFuelConsumption(): ?float
    {
        return $this->refueling_avg_fuel_consumption;
    }

    public function setRefuelingAvgFuelConsumption(float $refueling_avg_fuel_consumption): static
    {
        $this->refueling_avg_fuel_consumption = $refueling_avg_fuel_consumption;

        return $this;
    }
}
