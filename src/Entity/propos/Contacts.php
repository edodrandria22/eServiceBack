<?php

namespace App\Entity\propos;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Entity\utils\BaseEntite;
use App\Repository\propos\ContactsRepository;

#[ORM\Entity(repositoryClass: ContactsRepository::class)]
class Contacts extends BaseEntite
{
    #[ORM\Column(length: 255)]
    protected ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    protected ?string $email = null;

    #[ORM\Column(length: 255)]
    protected ?string $message = null;
    
    #[ORM\Column(length: 255)]
    protected ?string $numero = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;
        return $this;
    }
    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;
        return $this;
    }


}
