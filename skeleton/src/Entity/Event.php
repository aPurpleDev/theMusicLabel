<?php

namespace App\Entity;

use App\Interfaces\BuyableInterface;
use DateTimeInterface;
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

    /**
     * Event constructor.
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
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Event
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getStartDate(): ?DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * @param DateTimeInterface $startDate
     * @return Event
     */
    public function setStartDate(DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getEndDate(): ?DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * @param DateTimeInterface $endDate
     * @return Event
     */
    public function setEndDate(DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Event
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Event
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Artist|null
     */
    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    /**
     * @param Artist|null $artist
     * @return Event
     */
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

    /**
     * @param OrderLog $orderLog
     * @return Event
     */
    public function addOrderLog(OrderLog $orderLog): self
    {
        if (!$this->orderLogs->contains($orderLog)) {
            $this->orderLogs[] = $orderLog;
            $orderLog->setEvent($this);
        }

        return $this;
    }

    /**
     * @param OrderLog $orderLog
     * @return Event
     */
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

    /**
     * @return string|null
     */
    public function getBuyableName()
    {
        return $this->getName();
    }

    /**
     * @return string
     */
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
