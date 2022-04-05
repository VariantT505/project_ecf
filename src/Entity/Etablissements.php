<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etablissements
 *
 * @ORM\Table(name="etablissements", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})}, indexes={@ORM\Index(name="admid", columns={"admid"})})
 * @ORM\Entity
 */
class Etablissements
{
    /**
     * @var int
     *
     * @ORM\Column(name="etaid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $etaid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=false)
     */
    private $address;

    /**
     * @var int
     *
     * @ORM\Column(name="postalcode", type="integer", nullable=false)
     */
    private $postalcode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=60, nullable=false)
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="featuredimage", type="text", length=65535, nullable=false)
     */
    private $featuredimage;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=60, nullable=false, options={"fixed"=true})
     */
    private $password;

    /**
     * @var \Administrateurs
     *
     * @ORM\ManyToOne(targetEntity="Administrateurs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="admid", referencedColumnName="admid")
     * })
     */
    private $admid;

    public function getEtaid(): ?int
    {
        return $this->etaid;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalcode(): ?int
    {
        return $this->postalcode;
    }

    public function setPostalcode(int $postalcode): self
    {
        $this->postalcode = $postalcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFeaturedimage(): ?string
    {
        return $this->featuredimage;
    }

    public function setFeaturedimage(string $featuredimage): self
    {
        $this->featuredimage = $featuredimage;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAdmid(): ?Administrateurs
    {
        return $this->admid;
    }

    public function setAdmid(?Administrateurs $admid): self
    {
        $this->admid = $admid;

        return $this;
    }


}
