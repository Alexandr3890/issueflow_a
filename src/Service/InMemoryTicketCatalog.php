<?php

declare(strict_types=1);

namespace App\Service;

use App\Contract\TicketCatalogInterface;
use App\Entity\Ticket;
use App\Form\Model\TicketSearchCriteria;
use App\Model\TicketPriority;
use App\Model\TicketStatus;
use Doctrine\ORM\Tools\Pagination\Window;
use Doctrine\ORM\Tools\Pagination\WindowPage;

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
            )
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

    public function search(
        TicketSearchCriteria $criteria,
        int $page,
        int $pageSize
    ): WindowPage {
        $search = $criteria->query !== null
            ? trim($criteria->query)
            : '';

        $filteredTickets = array_values(array_filter(
            $this->tickets,
            function (Ticket $ticket) use ($criteria, $search): bool {

                if (
                    $search !== ''
                    && stripos($ticket->getCode(), $search) === false
                    && stripos($ticket->getTitle(), $search) === false
                ) {
                    return false;
                }

                if (
                    $criteria->priority !== null
                    && $ticket->getPriority() !== $criteria->priority
                ) {
                    return false;
                }

                if (
                    $criteria->status !== null
                    && $ticket->getStatus() !== $criteria->status
                ) {
                    return false;
                }

                if (
                    $criteria->category !== null
                    && $ticket->getCategory() !== $criteria->category
                ) {
                    return false;
                }

                if (
                    $criteria->assignee !== null
                    && $ticket->getAssignee() !== $criteria->assignee
                ) {
                    return false;
                }

                return true;
            }
        ));

        $page = max(1, $page);
        $pageSize = max(1, $pageSize);

        $window = Window::fromPageNumberAndSize($page, $pageSize);

        $items = array_slice(
            $filteredTickets,
            $window->getFirstResult(),
            $window->getMaxResults()
        );

        return new WindowPage(
            $items,
            count($filteredTickets),
            $window
        );
    }
}
