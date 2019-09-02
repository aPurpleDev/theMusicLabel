<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtistRepository")
 */
class Artist
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $style;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bio;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\News", mappedBy="news_artist_id")
     */
    private $artist_news_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Album", mappedBy="album_artist_id")
     */
    private $artist_album_id;

    public function __construct()
    {
        $this->artist_news_id = new ArrayCollection();
        $this->artist_album_id = new ArrayCollection();
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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(string $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * @return Collection|News[]
     */
    public function getArtistNewsId(): Collection
    {
        return $this->artist_news_id;
    }

    public function addArtistNewsId(News $artistNewsId): self
    {
        if (!$this->artist_news_id->contains($artistNewsId)) {
            $this->artist_news_id[] = $artistNewsId;
            $artistNewsId->setNewsArtistId($this);
        }

        return $this;
    }

    public function removeArtistNewsId(News $artistNewsId): self
    {
        if ($this->artist_news_id->contains($artistNewsId)) {
            $this->artist_news_id->removeElement($artistNewsId);
            // set the owning side to null (unless already changed)
            if ($artistNewsId->getNewsArtistId() === $this) {
                $artistNewsId->setNewsArtistId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Album[]
     */
    public function getArtistAlbumId(): Collection
    {
        return $this->artist_album_id;
    }

    public function addArtistAlbumId(Album $artistAlbumId): self
    {
        if (!$this->artist_album_id->contains($artistAlbumId)) {
            $this->artist_album_id[] = $artistAlbumId;
            $artistAlbumId->setAlbumArtistId($this);
        }

        return $this;
    }

    public function removeArtistAlbumId(Album $artistAlbumId): self
    {
        if ($this->artist_album_id->contains($artistAlbumId)) {
            $this->artist_album_id->removeElement($artistAlbumId);
            // set the owning side to null (unless already changed)
            if ($artistAlbumId->getAlbumArtistId() === $this) {
                $artistAlbumId->setAlbumArtistId(null);
            }
        }

        return $this;
    }
}
