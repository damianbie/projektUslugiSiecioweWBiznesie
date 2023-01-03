<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VehicleRepository::class)
 */
class Vehicle
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
    private $manufacturer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=4, nullable=true)
     */
    private $productionYear;

    /**
     * @ORM\Column(type="string", length=17, nullable=true)
     */
    private $vin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $registrationNumber;

    /**
     * @ORM\OneToMany(targetEntity=RepairOrder::class, mappedBy="vehicle")
     */
    private $repairOrders;

    /**
     * ORM\ManyToOne(targetEntity=Client::class, inversedBy="vehicles")
     * ORM\JoinColumn(nullable=true)
     */
    private $owner;

    public function __construct()
    {
        $this->repairOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(string $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getProductionYear(): ?string
    {
        return $this->productionYear;
    }

    public function setProductionYear(?string $productionYear): self
    {
        $this->productionYear = $productionYear;

        return $this;
    }

    public function getVin(): ?string
    {
        return $this->vin;
    }

    public function setVin(?string $vin): self
    {
        $this->vin = $vin;

        return $this;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(?string $registrationNumber): self
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    /**
     * @return Collection<int, RepairOrder>
     */
    public function getRepairOrders(): Collection
    {
        return $this->repairOrders;
    }

    public function addRepairOrder(RepairOrder $repairOrder): self
    {
        if (!$this->repairOrders->contains($repairOrder)) {
            $this->repairOrders[] = $repairOrder;
            $repairOrder->setVehicle($this);
        }

        return $this;
    }

    public function removeRepairOrder(RepairOrder $repairOrder): self
    {
        if ($this->repairOrders->removeElement($repairOrder)) {
            // set the owning side to null (unless already changed)
            if ($repairOrder->getVehicle() === $this) {
                $repairOrder->setVehicle(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?Client
    {
        return $this->owner;
    }
    public function addOwner(Client $owner): self
    {
        if (!$this->owner->contains($owner)) {
            $this->owner[] = $owner;
            $owner->setOwner($this);
        }

        return $this;
    }

    public function removeWorkPlace(Client $owner): self
    {
        if ($this->owner->removeElement($owner)) {
            // set the owning side to null (unless already changed)
            if ($owner->getOwner() === $this) {
                $owner->setOwner(null);
            }
        }

        return $this;
    }

    public function setOwner(?Client $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
