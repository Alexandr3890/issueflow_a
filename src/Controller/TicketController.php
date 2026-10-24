<?php

declare(strict_types=1);

namespace App\Controller;

use App\Contract\TicketCatalogInterface;
use App\Contract\TicketSlaCalculatorInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class TicketController extends AbstractController
{
    /* Constructor de TicketController
    Cuando Symfony levanta la aplicación, crea una instancia del controlador.
    Inyecto las interfaces de TicketCatalog y TicketSlaCalculator.
    */
    public function __construct(
        private readonly TicketCatalogInterface $ticketCatalog,
        private readonly TicketSlaCalculatorInterface $slaCalculator
    )
    {}

    #[Route('/tickets', name: 'app_ticket_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('ticket/index.html.twig', [
            'tickets' => $this->ticketCatalog->getTickets(),
            'title' => 'Incidencias'
        ]);
    }

    #[Route('/tickets/{id}', name: 'app_ticket_show', methods: ['GET'])]
    public function show(string $id): Response
    {
        $ticket = $this->ticketCatalog->find($id);

        if ($ticket === NULL) {
            throw $this->createNotFoundException('No existe la incidencia');
        }

       return $this->render('ticket/show.html.twig', [
    'ticket' => $ticket,
    'responseTargetHours' => $this->slaCalculator->getResponseTargetHours($ticket)
]);

    }
}