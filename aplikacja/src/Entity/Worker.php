<?php

namespace App\Entity;

use App\Repository\WorkerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WorkerRepository::class)
 */
class Worker
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
    private $surname;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @ORM\ManyToOne(targetEntity=WorkPlace::class, inversedBy="workers")
     */
    private $workPlace;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $hiredAt;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $bonus;

    /**
     * @ORM\ManyToMany(targetEntity=Serivce::class, mappedBy="madeBy")
     */
    private $serivces;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="worker", cascade={"persist", "remove"})
     */
    private $account;

    /**
     * @ORM\OneToMany(targetEntity=RepairOrder::class, mappedBy="registeredBy")
     */
    private $repairOrders;


    public function __construct()
    {
        // $this->workPlace = new ArrayCollection();
        $this->serivces = new ArrayCollection();
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

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getWorkPlace(): ?WorkPlace
    {
        return $this->workPlace;
    }

    public function addWorkPlace(WorkPlace $workPlace): self
    {
        if (!$this->workPlace->contains($workPlace)) {
            $this->workPlace[] = $workPlace;
            $workPlace->setWorker($this);
        }

        return $this;
    }

    public function removeWorkPlace(WorkPlace $workPlace): self
    {
        if ($this->workPlace->removeElement($workPlace)) {
            // set the owning side to null (unless already changed)
            if ($workPlace->getWorker() === $this) {
                $workPlace->setWorker(null);
            }
        }

        return $this;
    }

    public function setWorkPlace(?WorkPlace $workPlace): self
    {
        $this->workPlace = $workPlace;

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

    public function getHiredAt(): ?\DateTimeImmutable
    {
        return $this->hiredAt;
    }

    public function setHiredAt(\DateTimeImmutable $hiredAt): self
    {
        $this->hiredAt = $hiredAt;

        return $this;
    }

    public function getBonus(): ?float
    {
        return $this->bonus;
    }

    public function setBonus(?float $bonus): self
    {
        $this->bonus = $bonus;

        return $this;
    }

    /**
     * @return Collection<int, Serivce>
     */
    public function getSerivces(): Collection
    {
        return $this->serivces;
    }

    public function addSerivce(Serivce $serivce): self
    {
        if (!$this->serivces->contains($serivce)) {
            $this->serivces[] = $serivce;
            $serivce->addMadeBy($this);
        }

        return $this;
    }

    public function removeSerivce(Serivce $serivce): self
    {
        if ($this->serivces->removeElement($serivce)) {
            $serivce->removeMadeBy($this);
        }

        return $this;
    }

    public function getAccount(): ?User
    {
        return $this->account;
    }

    public function setAccount(?User $account): self
    {
        // unset the owning side of the relation if necessary
        if ($account === null && $this->account !== null) {
            $this->account->setWorker(null);
        }

        // set the owning side of the relation if necessary
        if ($account !== null && $account->getWorker() !== $this) {
            $account->setWorker($this);
        }

        $this->account = $account;

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
            $repairOrder->setRegisteredBy($this);
        }

        return $this;
    }

    public function removeRepairOrder(RepairOrder $repairOrder): self
    {
        if ($this->repairOrders->removeElement($repairOrder)) {
            // set the owning side to null (unless already changed)
            if ($repairOrder->getRegisteredBy() === $this) {
                $repairOrder->setRegisteredBy(null);
            }
        }

        return $this;
    }
}
