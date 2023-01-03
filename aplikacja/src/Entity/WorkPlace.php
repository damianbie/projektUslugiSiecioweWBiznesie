<?php

namespace App\Entity;

use App\Repository\WorkPlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=WorkPlaceRepository::class)
 * @UniqueEntity("name", message="{{ value }} już istnieje!")
 */
class WorkPlace
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 4,
     *      max = 255,
     *      minMessage = "Nazwa musi mieć więcej niż {{ limit }} znaki",
     *      maxMessage = "Nazwa musi być krótsza niż {{ limit }} znaków")
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * Assert\PositiveOrZero(message="Zarobki muszą być większe lub równe 0")
     */
    private $min_earnings;

    /**
     * @ORM\OneToMany(targetEntity=Worker::class, mappedBy="workPlace")
     */
    private $workers;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Opis nie może być pusty")
     */
    private $description;

    public function __construct()
    {
        $this->workers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMinEarnings(): ?float
    {
        return $this->min_earnings;
    }

    public function setMinEarnings(float $min_earnings): self
    {
        $this->min_earnings = $min_earnings;

        return $this;
    }

    /**
     * @return Collection<int, Worker>
     */
    public function getWorkers(): Collection
    {
        return $this->workers;
    }

    public function addWorker(Worker $worker): self
    {
        if (!$this->workers->contains($worker)) {
            $this->workers[] = $worker;
            $worker->setWorkPlace($this);
        }

        return $this;
    }

    public function removeWorker(Worker $worker): self
    {
        if ($this->workers->removeElement($worker)) {
            // set the owning side to null (unless already changed)
            if ($worker->getWorkPlace() === $this) {
                $worker->setWorkPlace(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
