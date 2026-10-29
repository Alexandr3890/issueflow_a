<?php

declare(strict_types=1);

namespace App\Controller;

use App\Contract\TicketCatalogInterface;
use App\Contract\TicketSlaCalculatorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TicketController extends AbstractController
{
    public function __construct(
        private readonly TicketCatalogInterface $ticketCatalog,
        private readonly TicketSlaCalculatorInterface $slaCalculator,
        private readonly LoggerInterface $logger
    ) {
    }

    #[Route('/tickets', name: 'app_ticket_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('ticket/index.html.twig', [
            'tickets' => $this->ticketCatalog->getTickets(),
            'title' => 'Incidencias'
        ]);
    }

    #[Route('/tickets/{code}', name: 'app_ticket_show', methods: ['GET'])]
    public function show(string $code): Response
    {
        $ticket = $this->ticketCatalog->findByCode($code);

        if ($ticket === null) {
            /*
            Guardo la información en el log para investigaciones posteriores
            */
            $this->logger->warning(
                'Se solicitó una incidencia no existente',
                [
                    'ticket_code' => $code,
                    'route' => 'app_ticket_show',
                ]
            );

            throw $this->createNotFoundException('No existe la incidencia');
        }

        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
            'responseTargetHours' => $this->slaCalculator->getResponseTargetHours($ticket)
        ]);
    }
}