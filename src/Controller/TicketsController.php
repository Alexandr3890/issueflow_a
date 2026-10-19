<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TicketsController extends AbstractController
{
    private const TICKETS = [
        [
            'id' => 'INC-1001',
            'title' => 'No puedo acceder',
            'priority' => 'urgent',
            'status' => 'open',
        ],
        [
            'id' => 'INC-1002',
            'title' => 'Error en factura',
            'priority' => 'high',
            'status' => 'in_progress',
        ],
        [
            'id' => 'INC-1003',
            'title' => 'Actualizar datos',
            'priority' => 'normal',
            'status' => 'closed',
        ],
        [
            'id' => 'INC-1004',
            'title' => 'Prueba Factura',
            'priority' => 'normal',
            'status' => 'closed',
        ],
    ];

    #[Route('/tickets', name: 'app_ticket_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('ticket/index.html.twig', [
            'title' => 'Tickets',
            'tickets' => self::TICKETS,
        ]);
    }

    #[Route('/tickets/{id}', name: 'app_ticket_show', methods: ['GET'])]
    public function show(string $id): Response
    {
        $ticket = array_find(
            self::TICKETS,
            fn(array $ticket): bool => $ticket['id'] === $id
        );

        if ($ticket === null) {
            throw $this->createNotFoundException('Ticket no encontrado');
        }

        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }
}