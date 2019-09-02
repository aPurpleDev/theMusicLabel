<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderLogRepository")
 */
class OrderLog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="orderLogs")
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Album", inversedBy="orderLogs")
     */
    private $album;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="orderLogs")
     */
    private $ordernumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    public function getOrdernumber(): ?Order
    {
        return $this->ordernumber;
    }

    public function setOrdernumber(?Order $ordernumber): self
    {
        $this->ordernumber = $ordernumber;

        return $this;
    }
}
