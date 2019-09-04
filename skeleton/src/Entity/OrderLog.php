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
     * @ORM\ManyToOne(targetEntity="Orders", inversedBy="orderLogs", cascade={"persist"})
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

    public function getOrdernumber(): ?Orders
    {
        return $this->ordernumber;
    }

    public function setOrdernumber(?Orders $ordernumber): self
    {
        $this->ordernumber = $ordernumber;

        return $this;
    }

    public function __toString()
    {
        $orderlogcontent = '';

        if($orderlogcontent === null)
        {
        $orderlogcontent = "Items in cart: ";
        }

        if($this->getAlbum() != null)
        {
        $orderlogcontent .= $this->getAlbum();
        }

        $orderlogcontent .= $this->getEvent();

        return nl2br($orderlogcontent);
    }
}
