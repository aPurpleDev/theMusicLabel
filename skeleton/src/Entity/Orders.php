<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Orders //standard Symfony Entity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $orderNumber;

    /**
     * @ORM\Column(type="datetime")
     */
    private $orderDate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $totalPrice;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderLog", mappedBy="ordernumber", cascade={"persist"})
     */
    private $orderLogs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="orders")
     */
    private $User;

    /**
     * Orders constructor.
     */
    public function __construct()
    {
        $this->orderLogs = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getOrderNumber(): ?int
    {
        return $this->orderNumber;
    }

    /**
     * @param int $orderNumber
     * @return int
     */
    public function setOrderNumber(int $orderNumber): int
    {
        $this->orderNumber = $orderNumber;

        return $orderNumber;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getOrderDate(): ?DateTimeInterface
    {
        return $this->orderDate;
    }

    /**
     * @param DateTimeInterface $orderDate
     * @return Orders
     */
    public function setOrderDate(DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    /**
     * @param float $totalPrice
     * @return Orders
     */
    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * @return Collection|OrderLog[]
     */
    public function getOrderLogs(): Collection
    {
        return $this->orderLogs;
    }

    /**
     * @param OrderLog $orderLog
     * @return Orders
     */
    public function addOrderLog(OrderLog $orderLog): self
    {
        if (!$this->orderLogs->contains($orderLog)) {
            $this->orderLogs[] = $orderLog;
            $orderLog->setOrdernumber($this);
        }

        return $this;
    }

    /**
     * @param OrderLog $orderLog
     * @return Orders
     */
    public function removeOrderLog(OrderLog $orderLog): self
    {
        if ($this->orderLogs->contains($orderLog)) {
            $this->orderLogs->removeElement($orderLog);
            // set the owning side to null (unless already changed)
            if ($orderLog->getOrdernumber() === $this) {
                $orderLog->setOrdernumber(null);
            }
        }

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->User;
    }

    /**
     * @param User|null $User
     * @return Orders
     */
    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}
