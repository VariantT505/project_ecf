<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservations
 *
 * @ORM\Table(name="reservations", uniqueConstraints={@ORM\UniqueConstraint(name="startdate", columns={"startdate", "enddate", "suiid"})}, indexes={@ORM\Index(name="cliid", columns={"cliid"}), @ORM\Index(name="suiid", columns={"suiid"})})
 * @ORM\Entity
 */
class Reservations
{
    /**
     * @var int
     *
     * @ORM\Column(name="resid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $resid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startdate", type="date", nullable=false)
     */
    private $startdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enddate", type="date", nullable=false)
     */
    private $enddate;

    /**
     * @var \Clients
     *
     * @ORM\ManyToOne(targetEntity="Clients")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cliid", referencedColumnName="cliid")
     * })
     */
    private $cliid;

    /**
     * @var \Suites
     *
     * @ORM\ManyToOne(targetEntity="Suites")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="suiid", referencedColumnName="suiid")
     * })
     */
    private $suiid;

    public function getResid(): ?int
    {
        return $this->resid;
    }

    public function getStartdate(): ?\DateTimeInterface
    {
        return $this->startdate;
    }

    public function setStartdate(\DateTimeInterface $startdate): self
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getEnddate(): ?\DateTimeInterface
    {
        return $this->enddate;
    }

    public function setEnddate(\DateTimeInterface $enddate): self
    {
        $this->enddate = $enddate;

        return $this;
    }

    public function getCliid(): ?Clients
    {
        return $this->cliid;
    }

    public function setCliid(?Clients $cliid): self
    {
        $this->cliid = $cliid;

        return $this;
    }

    public function getSuiid(): ?Suites
    {
        return $this->suiid;
    }

    public function setSuiid(?Suites $suiid): self
    {
        $this->suiid = $suiid;

        return $this;
    }


}
