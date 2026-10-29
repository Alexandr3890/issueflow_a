<?php

declare(strict_types=1);

namespace App\Contract;

use App\Entity\Ticket;

/*
    Contrato que define qué necesita mi aplicación de cualquier catálogo
    de tickets.

    La interfaz describe qué operaciones deben existir,
    pero no cómo se llevan a cabo.
*/

interface TicketCatalogInterface
{
    /* Método que devuelve un array con todas las incidencias */
    public function getTickets(): array;

    /* Método que busca una incidencia según su código
       y devuelve null si no existe */
    public function findByCode(string $code): ?Ticket; 
    }