<?php

declare(strict_types=1);

namespace App\Tests\Model;

use App\Entity\Ticket;
use App\Model\TicketPriority;
use App\Model\TicketStatus;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * Tests unitarios de la entidad Ticket.
 */
final class TicketTest extends TestCase
{
    #[Test]
    public function it_creates_a_ticket_with_its_values(): void
    {
        $ticket = new Ticket(
            code: 'INC-1001',
            title: 'Error de acceso',
            priority: TicketPriority::Urgent,
            status: TicketStatus::Open,
        );

        self::assertSame('INC-1001', $ticket->getCode());
        self::assertSame('Error de acceso', $ticket->getTitle());
        self::assertSame(TicketPriority::Urgent, $ticket->getPriority());
        self::assertSame(TicketStatus::Open, $ticket->getStatus());
    }

    #[Test]
    public function it_reports_whether_the_ticket_is_urgent_and_closed(): void
    {
        $ticket = new Ticket(
            code: 'INC-1003',
            title: 'Incidencia válida',
            priority: TicketPriority::Urgent,
            status: TicketStatus::Closed,
        );

        self::assertTrue($ticket->isUrgent());
        self::assertTrue($ticket->isClosed());
    }
}