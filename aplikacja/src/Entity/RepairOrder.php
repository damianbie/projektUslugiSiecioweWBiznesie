<?php

namespace App\Entity;

use App\Repository\RepairOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RepairOrderRepository::class)
 */
class RepairOrder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="repairOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Vehicle::class, inversedBy="repairOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicle;

    /**
     * @ORM\OneToMany(targetEntity=Serivce::class, mappedBy="repairOrder", fetch="EAGER")
     */
    private $services;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $orderedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Worker::class, inversedBy="repairOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $registeredBy;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ClientCode;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $additionalInfo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $additionalInfoPriv;

    public function __construct()
    {
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * @return Collection<int, Serivce>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Serivce $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
            $service->setRepairOrder($this);
        }

        return $this;
    }

    public function removeService(Serivce $service): self
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getRepairOrder() === $this) {
                $service->setRepairOrder(null);
            }
        }

        return $this;
    }

    public function getOrderedAt(): ?\DateTimeImmutable
    {
        return $this->orderedAt;
    }

    public function setOrderedAt(\DateTimeImmutable $orderedAt): self
    {
        $this->orderedAt = $orderedAt;

        return $this;
    }

    public function getRegisteredBy(): ?Worker
    {
        return $this->registeredBy;
    }

    public function setRegisteredBy(?Worker $registeredBy): self
    {
        $this->registeredBy = $registeredBy;

        return $this;
    }

    public function getClientCode(): ?string
    {
        return $this->ClientCode;
    }

    public function setClientCode(string $ClientCode): self
    {
        $this->ClientCode = $ClientCode;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getAdditionalInfo(): ?string
    {
        return $this->additionalInfo;
    }

    public function setAdditionalInfo(?string $additionalInfo): self
    {
        $this->additionalInfo = $additionalInfo;

        return $this;
    }

    public function getAdditionalInfoPriv(): ?string
    {
        return $this->additionalInfoPriv;
    }

    public function setAdditionalInfoPriv(?string $additionalInfoPriv): self
    {
        $this->additionalInfoPriv = $additionalInfoPriv;

        return $this;
    }
}
