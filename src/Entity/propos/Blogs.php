<?php

namespace App\Entity\propos;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Entity\utils\BaseEntite;
use App\Entity\utils\Fichiers;
use App\Repository\propos\BlogsRepository;

#[ORM\Entity(repositoryClass: BlogsRepository::class)]
class Blogs extends BaseEntite
{
    #[ORM\Column(length: 255)]
    protected ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    protected ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Fichiers::class)]
    #[ORM\JoinColumn(nullable: true)]
    protected ?Fichiers $image = null;
    
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this; 
    }
    
    public function getImage(): ?Fichiers
    {
        return $this->image;
    }
    
    public function setImage(?Fichiers $image): static
    {
        $this->image = $image;
        return $this;
    }
    public function toArray(array $exclude = []): array
    {
        $data = parent::toArray($exclude);
        if ($this->image) {
            $data['image'] = $this->image->toArray($exclude);
        }
        return $data;
    }
    
}
