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
            'id' => 101,
            'title' => 'No puedo acceder',
            'priority' => 'urgent',
            'status' => 'open',
        ],
        [
            'id' => 102,
            'title' => 'Error en factura',
            'priority' => 'high',
            'status' => 'in_progress',
        ],
        [
            'id' => 103,
            'title' => 'Actualizar datos',
            'priority' => 'normal',
            'status' => 'closed',
        ],
        [
            'id' => 104,
            'title' => 'Prueba Factura',
            'priority' => 'normal',
            'status' => 'closed',
        ]
    ];

    #[Route('/tickets', name: 'app_ticket_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('ticket/index.html.twig', [
            'title' => 'Tickets',
            'tickets' => self::TICKETS,
        ]);
    }
}