<?php

namespace App\Entity;

use App\Repository\CarCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarCategoryRepository::class)]
class CarCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'carCategory', targetEntity: Car::class, orphanRemoval: true)]
    private Collection $car;

    public function __construct()
    {
        $this->car = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getCar(): Collection
    {
        return $this->car;
    }

    public function addCar(Car $car): static
    {
        if (!$this->car->contains($car)) {
            $this->car->add($car);
            $car->setCarCategory($this);
        }

        return $this;
    }

    public function removeCar(Car $car): static
    {
        if ($this->car->removeElement($car)) {
            // set the owning side to null (unless already changed)
            if ($car->getCarCategory() === $this) {
                $car->setCarCategory(null);
            }
        }

        return $this;
    }
}
