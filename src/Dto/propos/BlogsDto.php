<?php

namespace App\Dto\propos;

use Symfony\Component\Validator\Constraints as Assert;

class BlogsDto
{
    #[Assert\NotBlank(message: "Le titre est obligatoire.")]
    public ?string $title = null;

    #[Assert\NotBlank(message: "La description est obligatoire.")]
    public ?string $description = null;
}
