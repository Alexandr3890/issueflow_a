<?php

declare(strict_types=1);

namespace App\Tests\Model;

use App\Entity\Ticket;
use App\Model\TicketPriority;
use App\Model\TicketStatus;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class TicketTest extends TestCase
{
    #[Test]
    public function it_normalizes_the_title_when_the_ticket_is_created(): void
    {
        $ticket = new Ticket(
            code: 'INC-1001',
            title: '        No puedo iniciar sesión           ',
            priority: TicketPriority::Urgent,
            status: TicketStatus::Open,
        );

        self::assertSame('No puedo iniciar sesión', $ticket->getTitle());
    }

    #[Test]
    public function it_rejects_an_empty_title(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Ticket(
            code: 'INC-1003',
            title: '',
            priority: TicketPriority::High,
            status: TicketStatus::Open,
        );
    }

    public static function invalidIdentifierProvider(): iterable
    {
        yield 'not_inc_prefix' => ['1003'];
        yield 'too_many_digits' => ['INC-12345'];
        yield 'too_few_digits' => ['INC-123'];
        yield 'empty_identifier' => [''];
        yield 'lowercase_prefix' => ['inc-1001'];
    }

    #[Test]
    #[DataProvider('invalidIdentifierProvider')]
    public function it_rejects_an_invalid_identifier(string $invalidId): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Ticket(
            code: $invalidId,
            title: 'Incidencia válida',
            priority: TicketPriority::High,
            status: TicketStatus::Open,
        );
    }

    #[Test]
    public function it_returns_all_ticket_values_through_getters(): void
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
