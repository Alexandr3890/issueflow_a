<?php

declare(strict_types=1);

namespace App\Model;

enum TicketStatus: string
{
    case Open = 'open';
    case InProgress = 'in_progress';
    case Closed = 'closed';

    public function getLabel(): string
    {
        return match ($this) {
            self::Open => 'Abierto',
            self::InProgress => 'En progreso',
            self::Closed => 'Cerrado',
        };
    }

    /* Método que devuelve true si una incidencia está cerrada */
    public function isClosed(): bool
    {
        return $this === self::Closed;
    }
}