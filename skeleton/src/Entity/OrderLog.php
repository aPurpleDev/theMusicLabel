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
     * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="orderLogs", cascade={"persist"})
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Album", inversedBy="orderLogs", cascade={"persist"})
     */
    private $album;

    /**
     * @ORM\ManyToOne(targetEntity="Orders", inversedBy="orderLogs", cascade={"persist"})
     */
    private $ordernumber;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Event|null
     */
    public function getEvent(): ?Event
    {
        return $this->event;
    }

    /**
     * @param Event|null $event
     * @return OrderLog
     */
    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return Album|null
     */
    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    /**
     * @param Album|null $album
     * @return OrderLog
     */
    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    /**
     * @return Orders|null
     */
    public function getOrdernumber(): ?Orders
    {
        return $this->ordernumber;
    }

    /**
     * @param Orders|null $ordernumber
     * @return OrderLog
     */
    public function setOrdernumber(?Orders $ordernumber): self
    {
        $this->ordernumber = $ordernumber;

        return $this;
    }

    /**
     * @return string
     */
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
