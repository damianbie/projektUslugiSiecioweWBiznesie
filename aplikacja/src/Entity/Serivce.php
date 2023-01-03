<?php

namespace App\Entity;

use App\Repository\SerivceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SerivceRepository::class)
 */
class Serivce
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $price_netto;

    /**
     * @ORM\Column(type="float")
     */
    private $tax;

    /**
     * @ORM\ManyToMany(targetEntity=Worker::class, inversedBy="serivces")
     */
    private $madeBy;

    /**
     * @ORM\ManyToOne(targetEntity=RepairOrder::class, inversedBy="services")
     */
    private $repairOrder;

    /**
     * @ORM\Column(type="smallint")
     */
    private $state;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $service_cost;

    public function __construct()
    {
        $this->madeBy = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPriceNetto(): ?float
    {
        return $this->price_netto;
    }

    public function setPriceNetto(float $price_netto): self
    {
        $this->price_netto = $price_netto;

        return $this;
    }

    public function getTax(): ?float
    {
        return $this->tax;
    }

    public function setTax(float $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * @return Collection<int, Worker>
     */
    public function getMadeBy(): Collection
    {
        return $this->madeBy;
    }

    public function addMadeBy(Worker $madeBy): self
    {
        if (!$this->madeBy->contains($madeBy)) {
            $this->madeBy[] = $madeBy;
        }

        return $this;
    }

    public function removeMadeBy(Worker $madeBy): self
    {
        $this->madeBy->removeElement($madeBy);

        return $this;
    }

    public function getRepairOrder(): ?RepairOrder
    {
        return $this->repairOrder;
    }

    public function setRepairOrder(?RepairOrder $repairOrder): self
    {
        $this->repairOrder = $repairOrder;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getServiceCost(): ?float
    {
        return $this->service_cost;
    }

    public function setServiceCost(?float $service_cost): self
    {
        $this->service_cost = $service_cost;

        return $this;
    }
}
