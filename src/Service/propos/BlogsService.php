<?php

namespace App\Service\propos;

use App\Dto\propos\BlogsDto;
use App\Dto\utils\JoinCriteria;
use App\Dto\utils\OrderCriteria;
use App\Dto\utils\PaginationCriteria;
use App\Entity\propos\Blogs;
use App\Repository\propos\BlogsRepository;
use App\Service\utils\BaseService;
use App\Service\utils\FichiersService;
use App\Service\utils\ValidationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BlogsService extends BaseService
{
    private BlogsRepository $repository;
    private FichiersService $fichiersService;
    public function __construct(EntityManagerInterface $em, BlogsRepository $blogsRepository, ValidationService $validationService, FichiersService $fichiersService)
    {
        $this->em = $em;
        $this->repository = $blogsRepository;
        $this->fichiersService = $fichiersService;
         parent::__construct($em);
    }
    protected function getRepository()
    {
        return $this->repository;
    }
    public function getPaginated(OrderCriteria $orderCriteria, PaginationCriteria $paginationCriteria , array $joins = []) : array
    {
        $joins = [
        new JoinCriteria(
                'm.image', // relation depuis l'alias principal "m"
                'i',       // alias du join
                'LEFT'
            )
        ];
        return $this->repository->getPaginated($orderCriteria, $paginationCriteria, $joins);
    }

    public function saveDto(BlogsDto $dto,?UploadedFile $file): Blogs
    {
        $this->em->getConnection()->beginTransaction();
        try {
            $blog = new Blogs();
            $blog->setTitle($dto->title);
            $blog->setDescription($dto->description);

            if ($file) {
                $fichier = $this->fichiersService->saveToBlob($file);
                $blog->setImage($fichier);
            }

            $this->save($blog);
            $this->em->getConnection()->commit();
            return $blog;
            
        } catch (\Throwable $th) {
            $this->em->getConnection()->rollBack();
            throw $th;
        }
    }
    
}
