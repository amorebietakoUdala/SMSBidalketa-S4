<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Contact.
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=50, nullable=true, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=13, unique=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname1", type="string", length=255)
     */
    private $surname1;

    /**
     * @var string
     *
     * @ORM\Column(name="surname2", type="string", length=255, nullable=true)
     */
    private $surname2;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=255, nullable=true)
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="department", type="string", length=255)
     */
    private $department;

    /**
     * Labels for the contacts.
     *
     * @ORM\ManyToMany(targetEntity="Label", inversedBy="contacts", cascade={"persist"})
     * @ORM\JoinTable(name="labels_contacts")
     * @ORM\OrderBy({"name" = "ASC"})
     *      )
     */
    private $labels;

    public function __construct()
    {
        $this->labels = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return Contact
     */
    public function setUsername($username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Set telephone.
     *
     * @param string $telephone
     *
     * @return Contact
     */
    public function setTelephone($telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone.
     *
     * @return string
     */
    public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * Set nombre.
     *
     * @param string $name
     *
     * @return Contact
     */
    public function setName($name): ?self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set surname1.
     *
     * @param string $surname1
     *
     * @return Contact
     */
    public function setSurname1($surname1): self
    {
        $this->surname1 = $surname1;

        return $this;
    }

    /**
     * Get surname1.
     *
     * @return string
     */
    public function getSurname1(): ?string
    {
        return $this->surname1;
    }

    /**
     * Set surname2.
     *
     * @param string $surname2
     *
     * @return Contact
     */
    public function setSurname2($surname2): self
    {
        $this->surname2 = $surname2;

        return $this;
    }

    /**
     * Get surname2.
     *
     * @return string
     */
    public function getSurname2(): ?string
    {
        return $this->surname2;
    }

    /**
     * Set company.
     *
     * @param string $company
     *
     * @return Contact
     */
    public function setCompany($company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company.
     *
     * @return string
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }

    /**
     * Set department.
     *
     * @param string $department
     *
     * @return Contact
     */
    public function setDepartment($department): self
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department.
     *
     * @return string
     */
    public function getDepartment(): ?string
    {
        return $this->department;
    }

    /**
     * Set labels.
     *
     * @param array $labels
     *
     * @return Contact
     */
    public function setLabels($labels): self
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * Get labels.
     *
     * @return ArrayCollection|Labels[]
     */
    public function getLabels()
    {
        return $this->labels;
    }

    public function addLabel(Label $label)
    {
        if ($this->labels->contains($label)) {
            return;
        }
        $this->labels[] = $label;
    }

    public function removeLabel(Label $label)
    {
        if (!$this->labels->contains($label)) {
            return;
        }
        $this->labels->removeElement($label);
        // not needed for persistence, just keeping both sides in sync
        $label->removeContact($this);
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function __toString()
    {
        return $this->getFullName();
    }

    public function getFullName()
    {
        return $this->name.' '.$this->surname1.' '.$this->surname2;
    }

    public function hasLabel($label)
    {
        return $this->labels->contains($label);
    }

    public function __toArray()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            'surname1' => $this->surname1,
            'surname2' => $this->surname2,
            'company' => $this->company,
            'department' => $this->department,
            'labels' => $this->labels->toArray(),
        ];
    }
}
