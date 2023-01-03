<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $pesel;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $nip;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $added_at;

    /**
     * @ORM\Column(type="string", length=9, nullable=true)
     */
    private $regon;


    /**
     * @ORM\Column(type="boolean")
     */
    private $is_company;

    /**
     * @ORM\Column(type="string", length=22, nullable=true)
     */
    private $phoneNumber;

    //, fetch="EAGER
    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     */
    private $correspondenceAddress;

    /**
     * @ORM\OneToMany(targetEntity=Vehicle::class, mappedBy="owner")
     */
    private $vehicles;

    /**
     * @ORM\OneToMany(targetEntity=RepairOrder::class, mappedBy="client")
     */
    private $repairOrders;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
        $this->repairOrders = new ArrayCollection();
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPesel(): ?string
    {
        return $this->pesel;
    }

    public function setPesel(?string $pesel): self
    {
        $this->pesel = $pesel;

        return $this;
    }

    public function getNip(): ?string
    {
        return $this->nip;
    }

    public function setNip(?string $nip): self
    {
        $this->nip = $nip;

        return $this;
    }

    public function getAddedAt(): ?\DateTimeImmutable
    {
        return $this->added_at;
    }

    public function setAddedAt(\DateTimeImmutable $added_at): self
    {
        $this->added_at = $added_at;

        return $this;
    }

    public function getRegon(): ?string
    {
        return $this->regon;
    }

    public function setRegon(?string $regon): self
    {
        $this->regon = $regon;

        return $this;
    }

    public function getIsCompany(): ?bool
    {
        return $this->is_company;
    }

    public function setIsCompany(bool $is_company): self
    {
        $this->is_company = $is_company;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getCorrespondenceAddress(): ?Address
    {
        return $this->correspondenceAddress;
    }

    public function setCorrespondenceAddress(?Address $correspondenceAddress): self
    {
        $this->correspondenceAddress = $correspondenceAddress;

        return $this;
    }

    /**
     * @return Collection<int, Vehicle>
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): self
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles[] = $vehicle;
            $vehicle->setOwner($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): self
    {
        if ($this->vehicles->removeElement($vehicle)) {
            // set the owning side to null (unless already changed)
            if ($vehicle->getOwner() === $this) {
                $vehicle->setOwner(null);
            }
        }

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
            $repairOrder->setClient($this);
        }

        return $this;
    }

    public function removeRepairOrder(RepairOrder $repairOrder): self
    {
        if ($this->repairOrders->removeElement($repairOrder)) {
            // set the owning side to null (unless already changed)
            if ($repairOrder->getClient() === $this) {
                $repairOrder->setClient(null);
            }
        }

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
}