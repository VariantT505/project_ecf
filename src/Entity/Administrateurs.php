<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Administrateurs
 *
 * @ORM\Table(name="administrateurs", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\AdminRepo")
 */
class Administrateurs
{
    /**
     * @var int
     *
     * @ORM\Column(name="admid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $admid;

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

    public function getAdmid(): ?int
    {
        return $this->admid;
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


}
