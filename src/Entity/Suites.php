<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Suites
 *
 * @ORM\Table(name="suites", indexes={@ORM\Index(name="etaid", columns={"etaid"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\SuitesRepo")
 */
class Suites
{
    /**
     * @var int
     *
     * @ORM\Column(name="suiid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $suiid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="featuredimage", type="text", length=65535, nullable=false)
     */
    private $featuredimage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="galleryone", type="text", length=65535, nullable=false)
     */
    private $galleryone;

    /**
     * @var string
     *
     * @ORM\Column(name="gallerytwo", type="text", length=65535, nullable=false)
     */
    private $gallerytwo;

    /**
     * @var string
     *
     * @ORM\Column(name="gallerythree", type="text", length=65535, nullable=false)
     */
    private $gallerythree;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bookingurl", type="text", length=65535, nullable=true)
     */
    private $bookingurl;

    /**
     * @var \Etablissements
     *
     * @ORM\ManyToOne(targetEntity="Etablissements")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etaid", referencedColumnName="etaid")
     * })
     */
    private $etaid;

    public function getSuiid(): ?int
    {
        return $this->suiid;
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

    public function getFeaturedimage(): ?string
    {
        return $this->featuredimage;
    }

    public function setFeaturedimage(string $featuredimage): self
    {
        $this->featuredimage = $featuredimage;

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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getGalleryone(): ?string
    {
        return $this->galleryone;
    }

    public function setGalleryone(string $galleryone): self
    {
        $this->galleryone = $galleryone;

        return $this;
    }

    public function getGallerytwo(): ?string
    {
        return $this->gallerytwo;
    }

    public function setGallerytwo(string $gallerytwo): self
    {
        $this->gallerytwo = $gallerytwo;

        return $this;
    }

    public function getGallerythree(): ?string
    {
        return $this->gallerythree;
    }

    public function setGallerythree(string $gallerythree): self
    {
        $this->gallerythree = $gallerythree;

        return $this;
    }

    public function getBookingurl(): ?string
    {
        return $this->bookingurl;
    }

    public function setBookingurl(?string $bookingurl): self
    {
        $this->bookingurl = $bookingurl;

        return $this;
    }

    public function getEtaid(): ?Etablissements
    {
        return $this->etaid;
    }

    public function setEtaid(?Etablissements $etaid): self
    {
        $this->etaid = $etaid;

        return $this;
    }
    
    public function __toString(): string
    {
        return $this->getTitle();
    }
}
