<?php

namespace App\Repository\propos;

use App\Entity\propos\Blogs;
use App\Repository\utils\BaseRepository;
use Doctrine\Persistence\ManagerRegistry;

class BlogsRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blogs::class);
    }


}
