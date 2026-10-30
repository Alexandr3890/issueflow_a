<?php

declare(strict_types=1);

namespace App\Service;

use App\Contract\TicketCatalogInterface;
use App\Entity\Ticket;
use App\Model\TicketPriority;
use App\Model\TicketStatus;



final class InMemoryTicketCatalog implements TicketCatalogInterface
{
    private array $tickets;

    public function __construct()
    {
        $this->tickets = [
            new Ticket(
                code: 'INC-1001',
                title: 'No puedo acceder',
                priority: TicketPriority::Urgent,
                status: TicketStatus::Open
            ),
            new Ticket(
                code: 'INC-1002',
                title: 'Error en factura',
                priority: TicketPriority::High,
                status: TicketStatus::InProgress
            ),
            new Ticket(
                code: 'INC-1003',
                title: 'Actualizar datos',
                priority: TicketPriority::Normal,
                status: TicketStatus::Closed
            ),
            new Ticket(
                code: 'INC-1004',
                title: 'El ordenador está en llamas',
                priority: TicketPriority::Urgent,
                status: TicketStatus::InProgress
            ),
            new Ticket(
                code: 'INC-4532',
                title: 'Olvidé mi contraseña',
                priority: TicketPriority::Low,
                status: TicketStatus::Open
            ),
        ];
    }

    public function getTickets(): array
    {
        return $this->tickets;
    }

    public function findByCode(string $code): ?Ticket
    {
        return array_find(
            $this->tickets,
            fn (Ticket $ticket): bool => $ticket->getCode() === $code
        );
    }
}
