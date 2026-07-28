<?php

namespace App\Controller\Api\propos;

use App\Controller\Api\utils\BaseApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Annotation\TokenRequired;
use App\Dto\propos\BlogsDto;
use App\Dto\utils\OrderCriteria;
use App\Dto\utils\PaginationCriteria;
use App\Service\propos\BlogsService;
use DateTimeImmutable;

#[Route('/blogs')]
class BlogsController extends BaseApiController
{
    private BlogsService $blogsService;
    public function __construct(BlogsService $blogsService)
    {
        $this->blogsService = $blogsService;
    }
    #[Route('', name: 'get_all_blogs', methods: ['GET'])]
    // #[TokenRequired]
    public function getAllContacts(Request $request): JsonResponse
    {
        try {
            $dateParam = $request->query->get('date');
            $date = $dateParam ? new DateTimeImmutable($dateParam) : new DateTimeImmutable();
            $limitParam = $request->query->get('limit');
            $limit = $limitParam ? (int)$limitParam : ($_ENV['LIMIT_PAGINATIONS'] ?? 10);
            $paginationCriteria = new PaginationCriteria($date, $limit);
            $orderCriteria = new OrderCriteria();
            $blogs = $this->blogsService->getPaginated($orderCriteria, $paginationCriteria);
            $excludes = ['deletedAt'];
            $data = $this->blogsService->transformerArray($blogs, $excludes);
            
            return $this->jsonSuccess($data);

        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage(), 400);
        }

    }

    #[Route('', name: 'create_blog', methods: ['POST'])]
    // #[TokenRequired]
    public function createBlog(Request $request): JsonResponse
    {
        try {
            $dto = $this->deserializeFormDataAndValidate(
                $request,
                BlogsDto::class
            );
            $uploadedFile = $request->files->get('fichier');
            $user = $this->blogsService->saveDto($dto, $uploadedFile);
            
           $excludes = ['createdAt', 'deletedAt'];
            $data = $user->toArray($excludes);
            return $this->jsonSuccess($data);

        } catch (\Throwable $e) {
            return $this->jsonError($e->getMessage(), 400);
        }
    }

    #[Route('/{id}', methods: ['GET'], requirements: ['id' => '\d+'])]
    #[TokenRequired]
    public function getOneUser(int $id): JsonResponse
    {
        try {
            $user =$this->blogsService->getById($id);

            if (!$user) {
                return $this->jsonError('Blog non trouvé', 404);
            }

            $excludes = ['createdAt', 'deletedAt'];
            $data = $user->toArray($excludes);
            return $this->jsonSuccess($data);
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage(), 400);
        }
    }   
}


