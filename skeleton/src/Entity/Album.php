<?php

namespace App\Entity;

use App\Interfaces\BuyableInterface;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlbumRepository")
 */
class Album implements BuyableInterface
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
    private $title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $releaseDate;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Track", mappedBy="album")
     */
    private $tracks;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Artist", inversedBy="albums", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $artist;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderLog", mappedBy="album")
     */
    private $orderLogs;

    /**
     * Album constructor.
     */
    public function __construct()
    {
        $this->tracks = new ArrayCollection();
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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Album
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getReleaseDate(): ?DateTimeInterface
    {
        return $this->releaseDate;
    }

    /**
     * @param DateTimeInterface $releaseDate
     * @return Album
     */
    public function setReleaseDate(DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

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
     * @return Album
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Track[]
     */
    public function getTracks(): Collection
    {
        return $this->tracks;
    }

    /**
     * @param Track $track
     * @return Album
     */
    public function addTrack(Track $track): self
    {
        if (!$this->tracks->contains($track)) {
            $this->tracks[] = $track;
            $track->setAlbum($this);
        }

        return $this;
    }

    /**
     * @param Track $track
     * @return Album
     */
    public function removeTrack(Track $track): self
    {
        if ($this->tracks->contains($track)) {
            $this->tracks->removeElement($track);
            // set the owning side to null (unless already changed)
            if ($track->getAlbum() === $this) {
                $track->setAlbum(null);
            }
        }

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
     * @return Album
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
     * @return Album
     */
    public function addOrderLog(OrderLog $orderLog): self
    {
        if (!$this->orderLogs->contains($orderLog)) {
            $this->orderLogs[] = $orderLog;
            $orderLog->setAlbum($this);
        }

        return $this;
    }

    /**
     * @param OrderLog $orderLog
     * @return Album
     */
    public function removeOrderLog(OrderLog $orderLog): self
    {
        if ($this->orderLogs->contains($orderLog)) {
            $this->orderLogs->removeElement($orderLog);
            // set the owning side to null (unless already changed)
            if ($orderLog->getAlbum() === $this) {
                $orderLog->setAlbum(null);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBuyableName()
    {
        return $this->getTitle();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return  'Album title: ' . $this->getTitle() . '.' .
            ' Produced by the artist: ' . $this->getArtist()->getName()  .
            '. Released at date: ' . $this->getReleaseDate()->format('Y-m-d') .
            '. Price : ' . $this->getPrice() . ' €';
    }
}
