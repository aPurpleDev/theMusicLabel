<?php

namespace App\Entity;

use App\Interfaces\BuyableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event implements BuyableInterface //standard Symfony Entity with a redefined __toString()
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Artist", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $artist;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderLog", mappedBy="event")
     */
    private $orderLogs;

    public function __construct()
    {
        $this->orderLogs = new ArrayCollection();
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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * @return Collection|OrderLog[]
     */
    public function getOrderLogs(): Collection
    {
        return $this->orderLogs;
    }

    public function addOrderLog(OrderLog $orderLog): self
    {
        if (!$this->orderLogs->contains($orderLog)) {
            $this->orderLogs[] = $orderLog;
            $orderLog->setEvent($this);
        }

        return $this;
    }

    public function removeOrderLog(OrderLog $orderLog): self
    {
        if ($this->orderLogs->contains($orderLog)) {
            $this->orderLogs->removeElement($orderLog);
            // set the owning side to null (unless already changed)
            if ($orderLog->getEvent() === $this) {
                $orderLog->setEvent(null);
            }
        }

        return $this;
    }

    public function getBuyableName()
    {
        return $this->getName();
    }

    public function __toString()
    {
        return 'Event name: ' . $this->getName() . '.' .
            ' Performed by the artist: ' . $this->getArtist()->getName() .
            '. Taking place in: ' . $this->getCity() .
            '. Start date: ' . $this->getStartDate()->format('Y-m-d') .
            '. End date: ' . $this->getEndDate()->format('Y-m-d') .
            '. Price : ' . $this->getPrice() . ' €';
    }
}
