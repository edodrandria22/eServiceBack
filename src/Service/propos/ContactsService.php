<?php

namespace App\Service\propos;

use App\Dto\propos\ContactsDto;
use App\Dto\utils\OrderCriteria;
use App\Dto\utils\PaginationCriteria;
use App\Entity\propos\Contacts;
use App\Repository\propos\ContactsRepository;
use App\Service\utils\BaseService;
use App\Service\utils\ValidationService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class ContactsService extends BaseService
{
    private ContactsRepository $repository;
    public function __construct(EntityManagerInterface $em, ContactsRepository $contactsRepositoryRepository, ValidationService $validationService)
    {
        $this->em = $em;
        $this->repository = $contactsRepositoryRepository;
         parent::__construct($em);
    }
    protected function getRepository()
    {
        return $this->repository;
    }
    public function saveDto(ContactsDto $dto): Contacts
    {
        $contact = new Contacts();
        $contact->setNom($dto->nom);
        $contact->setEmail($dto->email);
        $contact->setMessage($dto->message);
        $contact->setNumero($dto->numero);

        $this->save($contact);
        return $contact;
    }
    public function getPaginatedJson(DateTimeImmutable $date, int $limit): array
    {
        $paginationCriteria = new PaginationCriteria($date, $limit);
        $orderCriteria = new OrderCriteria();
        $contacts = $this->getPaginated($orderCriteria, $paginationCriteria);
        $excludes = ['deletedAt'];
        return $this->transformerArray($contacts, $excludes);
    }
    
}
