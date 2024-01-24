<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "user_id", type: 'integer')]
    private int $id;

    #[ORM\OneToMany(targetEntity: Car::class, mappedBy: 'user', fetch:'EAGER', cascade: ['persist'])]
    private Collection $cars;

    #[ORM\Column(name: "user_login", type: 'string', length: 180, unique: true)]
    private ?string $login;

    #[ORM\Column(name: "user_email", type: 'string', length: 180, unique: true)]
    private ?string $email;

    #[ORM\Column(name: "user_password", type: 'string')]
    private string $password;

    #[ORM\Column(name: "user_name", type: 'string')]
    private string $userName;

    #[ORM\Column(name: "user_last_name", type: 'string')]
    private string $userLastName;

    #[ORM\Column(name: 'user_roles', type: "json", length: 255, nullable: true)]
    private ?array $roles = null;

    public function __construct() {
        $this->cars = new ArrayCollection();
    }

    public function addCar(Car $car): void {
        $this->cars[] = $car;
    }

    public function removeCar(Car $car): void {
        $this->cars->removeElement($car);
    }

    public function getCars(): Collection{
        return $this->cars;
    }

    public function getCar($id) {
        return $this->getCars()->filter(
            function($car) use($id) {
                return $car->getCarId()==$id;
            }
        )->first();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserLogin(): ?string
    {
        return $this->login;
    }

    public function setUserLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }
    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getUserLastName(): ?string
    {
        return $this->userLastName;
    }
    public function setUserLastName(string $userLastName): self
    {
        $this->userLastName = $userLastName;

        return $this;
    }



    /**
     * The public representation of the user (e.g. a username, an email address, etc.)
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getRoles(): array
    {

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }
}