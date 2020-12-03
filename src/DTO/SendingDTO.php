<?php

namespace App\DTO;

use App\Entity\Contact;
use Doctrine\Common\Collections\ArrayCollection;

class SendingDTO
{
    private $telephone;
    private $message;
    private $labels;
    private $selected;
    private $date;

    public function __construct(Contact $contact = null)
    {
        if ($contact) {
            $this->extract($contact);
        } else {
            $this->labels = new ArrayCollection();
        }
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public function getLabels()
    {
        return $this->labels;
    }

    public function setLabels($labels)
    {
        $this->labels = $labels;

        return $this;
    }

    public function getSelected()
    {
        return $this->selected;
    }

    public function setSelected($selected)
    {
        $this->selected = $selected;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }
}
