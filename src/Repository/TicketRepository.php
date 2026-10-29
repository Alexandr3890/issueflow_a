<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class TicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    /**
     * @return Ticket[]
     */
    public function getTickets(): array
    {
        // TODO: Implementar la consulta a la base de datos.
        return [];
    }

    public function findByCode(string $code): ?Ticket
    {
        // TODO: Implementar la consulta a la base de datos.
        return null;
    }
}