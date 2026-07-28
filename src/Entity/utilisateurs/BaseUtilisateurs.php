<?php

namespace App\Entity\utilisateurs;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\utils\BaseEntite;

#[ORM\MappedSuperclass]
abstract class BaseUtilisateurs extends BaseEntite
{
    #[ORM\Column(length: 255)]
    protected ?string $email = null;

    #[ORM\Column(length: 255)]
    protected ?string $mdp = null;

    #[ORM\Column(length: 255)]
    protected ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $prenom = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

}
