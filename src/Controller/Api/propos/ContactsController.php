<?php

namespace App\Controller\Api\propos;

use App\Controller\Api\utils\BaseApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Annotation\TokenRequired;
use App\Dto\propos\ContactsDto;
use App\Service\propos\ContactsService;
use DateTimeImmutable;

#[Route('/contacts')]
class ContactsController extends BaseApiController
{
    private ContactsService $contactsService;
    public function __construct(ContactsService $contactsService)
    {
        $this->contactsService = $contactsService;
    }
    #[Route('', name: 'get_all_contacts', methods: ['GET'])]
    // #[TokenRequired]
    public function getAllContacts(Request $request): JsonResponse
    {
        try {
            $dateParam = $request->query->get('date');
            $date = $dateParam ? new DateTimeImmutable($dateParam) : new DateTimeImmutable();
            $limitParam = $request->query->get('limit');
            $limit = $limitParam ? (int)$limitParam : ($_ENV['LIMIT_PAGINATIONS'] ?? 10);
            
            $data = $this->contactsService->getPaginatedJson($date, $limit);
            return $this->jsonSuccess($data);

        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage(), 400);
        }

    }

    #[Route('', name: 'create_contact', methods: ['POST'])]
    // #[TokenRequired]
    public function createContact(Request $request): JsonResponse
    {
        try {
            $dto = $this->deserializeAndValidate(
                $request,
                ContactsDto::class
            );
            $user = $this->contactsService->saveDto($dto);
            
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
            $user =$this->contactsService->getById($id);

            if (!$user) {
                return $this->jsonError('Contact non trouvé', 404);
            }

            $excludes = ['createdAt', 'deletedAt'];
            $data = $user->toArray($excludes);
            return $this->jsonSuccess($data);
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage(), 400);
        }
    }   
}


