<?php

namespace App\Dto\utilisateurs;

use Symfony\Component\Validator\Constraints as Assert;

class UtilisateursDto
{
    #[Assert\NotBlank(message: "L'email est obligatoire.")]
    #[Assert\Email(message: "Format d'email invalide.")]
    public ?string $email = null;

    #[Assert\NotBlank(message: "Le mot de passe est obligatoire.")]
    #[Assert\Length(
        min: 6,
        minMessage: "Le mot de passe doit contenir au moins {{ limit }} caractères."
    )]
    public ?string $mdp = null;

    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    public ?string $nom = null;

    // #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    public ?string $prenom = null;


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

}