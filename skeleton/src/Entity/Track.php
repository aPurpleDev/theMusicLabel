<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrackRepository")
 */
class Track
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Album", inversedBy="album_rtrack_id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $track_album_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTrackAlbumId(): ?Album
    {
        return $this->track_album_id;
    }

    public function setTrackAlbumId(?Album $track_album_id): self
    {
        $this->track_album_id = $track_album_id;

        return $this;
    }
}
