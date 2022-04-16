<?php

namespace App\Entity;

use App\Repository\EtablRepo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Etablissements
 *
 * @ORM\Table(name="etablissements", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})}, indexes={@ORM\Index(name="admid", columns={"admid"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\EtablRepo")
 */
class Etablissements implements UserInterface, PasswordAuthenticatedUserInterface
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
     * @ORM\Column(name="roles", type="json", nullable=true)
     */
    private $roles = 'ROLE_GERANT';

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
     * @ORM\Column(name="password", type="string", length=255, nullable=false, options={"fixed"=true})
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

    /**
     * @var \Suites
     *
     * @ORM\OneToMany(targetEntity="Suites", mappedBy="Etablissements")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etaid", referencedColumnName="etaid")
     * })
     */
    private $suiid;

    /**
     * @var \Reservations
     *
     * @ORM\OneToMany(targetEntity="Reservations", mappedBy="Etablissements")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="resid", referencedColumnName="resid")
     * })
     */
    private $resid;

    public function __construct()
    {
        $this->suiid = new ArrayCollection();
    }

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

      /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles = [];
        $roles[] = 'ROLE_GERANT';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

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

    public function getAdmid() : ?Administrateurs
    {
        return $this->admid;
    }

    public function setAdmid(?Administrateurs $admid): self
    {
        $this->admid = $admid;

        return $this;
    }

   /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
        /**
     * @return Collection<int, Suites>
     */
    public function getSuiid(): Collection
    {
        return $this->suiid;
    }

    public function addSuiid(Suites $suiid): self
    {
        if (!$this->suiid->contains($suiid)) {
            $this->suiid[] = $suiid;
            $suiid->setEtaid($this);
        }

        return $this;
    }

    public function removeSuiid(Suites $suiid): self
    {
        if ($this->suiid->removeElement($suiid)) {
            // set the owning side to null (unless already changed)
            if ($suiid->getEtaid() === $this) {
                $suiid->setEtaid(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
