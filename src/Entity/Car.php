<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\DBAL\Types\Types;
use Exception;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CarRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Car implements PrintableInterface 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $car_id = null;

    #[ORM\OneToMany(targetEntity: Refueling::class, mappedBy: 'car', cascade: ['persist'])]
    private Collection $refuelings;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'cars', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'user_id')]
    private User|null $user = null;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column(length: 255)]
    private ?string $car_brand = null;

    #[ORM\Column(length: 255)]
    private ?string $car_model = null;

    #[ORM\Column(length: 255)]
    private ?string $car_fuel = null;

    #[ORM\Column(length: 10)]
    private ?int $car_odometer = null;

    public function __construct() {
        $this->refuelings = new ArrayCollection();
    }

    public function addRefueling(Refueling $refueling): void {
        //$this->refuelings->add($refueling);
        $this->refuelings[] = $refueling;
    }

    public function removeRefueling(Refueling $refueling): void {
        $this->refuelings->removeElement($refueling);
    }

    public function getRefuelings(): Collection{
        return $this->refuelings;
    }

    public function getRefueling($id) {
        return $this->getRefuelings()->filter(
            function($refueling) use($id) {
                return $refueling->getRefuelingId()==$id;
            }
        )->first();
    }

    public function setUser(User $user): self{
        $this->user=$user;
        return $this;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function getCarId(): ?int
    {
        return $this->car_id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getCarBrand(): ?string
    {
        return $this->car_brand;
    }

    public function setCarBrand(string $car_brand): static
    {
        $this->car_brand = $car_brand;

        return $this;
    }

    public function getCarModel(): ?string
    {
        return $this->car_model;
    }

    public function setCarModel(string $car_model): static
    {
        $this->car_model = $car_model;

        return $this;
    }

    public function getCarFuel(): ?string
    {
        return $this->car_fuel;
    }

    public function setCarFuel(string $car_fuel): static
    {
        $this->car_fuel = $car_fuel;

        return $this;
    }

    public function getCarOdometer(): ?int
    {
        return $this->car_odometer;
    }

    public function setCarOdometer(int $car_odometer): static
    {
        $this->car_odometer = $car_odometer;

        return $this;
    }

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        if ($this->getUser()==null){
            throw new Exception('pusty');
        }
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        //$this->updatedAt = new DateTime('now');
    }

    public function getDisplayName(): string
    {
        return $this->getCarBrand();

    }
}
