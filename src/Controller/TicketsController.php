<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Model\Ticket;

final class TicketsController extends AbstractController
{
    public static function getAllTickets(): array
    {
        return [
            new Ticket(
                id: 'INC-1001',
                title: 'No puedo acceder',
                priority: 'urgent',
                status: 'open'
            ),
            new Ticket(
                id: 'INC-1002',
                title: 'Error en factura',
                priority: 'high',
                status: 'in_progress'
            ),
            new Ticket(
                id: 'INC-1003',
                title: 'Actualizar datos',
                priority: 'normal',
                status: 'closed'
            ),
            new Ticket(
                id: 'INC-1004',
                title: 'El ordenador está en llamas',
                priority: 'urgent',
                status: 'in_progress'
            )
        ];
    }

    #[Route('/tickets', name: 'app_ticket_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('ticket/index.html.twig', [
            'title' => 'incidencias',
            'tickets' => self::getAllTickets(),
        ]);
    }

    #[Route('/tickets/{id}', name: 'app_ticket_show', methods: ['GET'])]
    public function show(string $id): Response
    {
        $ticket = array_find(
            self::getAllTickets(),
            fn(Ticket $ticket): bool => $ticket->getId() === $id
        );

        if ($ticket === null) {
            throw $this->createNotFoundException('Ticket no encontrado');
        }

        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }
}