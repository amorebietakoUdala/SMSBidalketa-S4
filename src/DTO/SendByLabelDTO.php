<?php

namespace App\DTO;

use App\Entity\Contact;
use Doctrine\Common\Collections\ArrayCollection;

class SendByLabelDTO
{
    private $message;
    private $labels;
    private $selected;

    public function __construct(Contact $contact = null)
    {
        if ($contact) {
            $this->extract($contact);
        } else {
            $this->labels = new ArrayCollection();
        }
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
}
