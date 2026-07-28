<?php

namespace App\Dto\propos;

use Symfony\Component\Validator\Constraints as Assert;

class ContactsDto
{
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    public ?string $nom = null;

    #[Assert\NotBlank(message: "L'email est obligatoire.")]
    #[Assert\Email(message: "Format d'email invalide.")]
    public ?string $email = null;

    #[Assert\NotBlank(message: "Le message est obligatoire.")]
    public ?string $message = null;

    #[Assert\NotBlank(message: "Le numero est obligatoire.")]
    public ?string $numero = null;
}