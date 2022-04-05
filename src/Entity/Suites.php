<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Suites
 *
 * @ORM\Table(name="suites", indexes={@ORM\Index(name="etaid", columns={"etaid"})})
 * @ORM\Entity
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


}
