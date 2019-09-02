<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlbumRepository")
 */
class Album
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $releaseDate;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Track", mappedBy="track_album_id", orphanRemoval=true)
     */
    private $album_rtrack_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Artist", inversedBy="artist_album_id")
     */
    private $album_artist_id;

    public function __construct()
    {
        $this->album_rtrack_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

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

    /**
     * @return Collection|Track[]
     */
    public function getAlbumRtrackId(): Collection
    {
        return $this->album_rtrack_id;
    }

    public function addAlbumRtrackId(Track $albumRtrackId): self
    {
        if (!$this->album_rtrack_id->contains($albumRtrackId)) {
            $this->album_rtrack_id[] = $albumRtrackId;
            $albumRtrackId->setTrackAlbumId($this);
        }

        return $this;
    }

    public function removeAlbumRtrackId(Track $albumRtrackId): self
    {
        if ($this->album_rtrack_id->contains($albumRtrackId)) {
            $this->album_rtrack_id->removeElement($albumRtrackId);
            // set the owning side to null (unless already changed)
            if ($albumRtrackId->getTrackAlbumId() === $this) {
                $albumRtrackId->setTrackAlbumId(null);
            }
        }

        return $this;
    }

    public function getAlbumArtistId(): ?Artist
    {
        return $this->album_artist_id;
    }

    public function setAlbumArtistId(?Artist $album_artist_id): self
    {
        $this->album_artist_id = $album_artist_id;

        return $this;
    }
}
