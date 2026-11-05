<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Ticket;
use App\Model\TicketPriority;
use App\Model\TicketStatus;
use App\Service\TicketSlaCalculator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class TicketSlaCalculatorTest extends TestCase
{
    public static function priorityProvider(): iterable
    {
        yield 'urgent' => [TicketPriority::Urgent, 4];
        yield 'high' => [TicketPriority::High, 8];
        yield 'normal' => [TicketPriority::Normal, 24];
        yield 'low' => [TicketPriority::Low, 72];
    }

    #[Test]
    #[DataProvider('priorityProvider')]
    public function it_calculates_the_response_target_for_each_priority(
        TicketPriority $priority,
        int $expectedHours
    ): void {
        $ticket = new Ticket(
            code: 'INC-1001',
            title: 'Incidencia de prueba',
            priority: $priority,
            status: TicketStatus::Open
        );

        $calculator = new TicketSlaCalculator();

        $actualHours = $calculator->getResponseTargetHours($ticket);

        self::assertSame($expectedHours, $actualHours);
    }
}
