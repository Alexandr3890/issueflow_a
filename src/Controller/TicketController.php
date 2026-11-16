<?php

declare(strict_types=1);

namespace App\Controller;

use App\Contract\TicketCatalogInterface;
use App\Contract\TicketSlaCalculatorInterface;
use App\Form\Model\TicketCreateData;
use App\Form\Model\TicketSearchCriteria;
use App\Form\TicketFilterType;
use App\Form\TicketType;
use App\Service\TicketPaginator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class TicketController extends AbstractController
{
    public function __construct(
        private readonly TicketCatalogInterface $ticketCatalog,
        private readonly TicketSlaCalculatorInterface $slaCalculator,
        private readonly LoggerInterface $logger,
        private readonly EntityManagerInterface $entityManager,
        private readonly TicketPaginator $ticketPaginator
    ) {}

    /**
     * Muestra el listado de incidencias y permite filtrarlas.
     */
    #[Route('/tickets', name: 'app_ticket_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $lastTicketCode = null;

        if ($request->hasPreviousSession()) {
            $lastTicketCode = $request->getSession()->get('last_ticket_code');
        }

        $criteria = new TicketSearchCriteria();

        $filterForm = $this->createForm(TicketFilterType::class, $criteria, [
            'action' => $this->generateUrl('app_ticket_index'),
        ]);

        $filterForm->handleRequest($request);

        $ticketPage = $this->ticketPaginator->getTicketPage(
            $criteria,
            $request->query->get('page')
        );

        return $this->render('ticket/index.html.twig', [
            'title' => 'Incidencias',
            'lastTicketCode' => $lastTicketCode,
            'filterForm' => $filterForm->createView(),
            'ticketPage' => $ticketPage,
        ]);
    }

    /**
     * GET: muestra el formulario de creación.
     * POST: procesa y guarda una nueva incidencia.
     */
    #[Route('/tickets/new', name: 'app_ticket_new', methods: ['GET', 'POST'])]
    #[IsGranted(
        'ROLE_AGENT',
        message: 'Necesitas permisos de agente para crear incidencias.'
    )]
    public function new(Request $request): Response
    {
        $data = new TicketCreateData();

        $form = $this->createForm(TicketType::class, $data);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticket = $data->mapToTicket();

            $this->entityManager->persist($ticket);
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                sprintf('Incidencia %s creada correctamente.', $ticket->getCode())
            );

            return $this->redirectToRoute(
                'app_ticket_show',
                ['code' => $ticket->getCode()]
            );
        }

        return $this->render('ticket/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Muestra el detalle de una incidencia.
     */
    #[Route('/tickets/{code}', name: 'app_ticket_show', methods: ['GET'])]
    public function show(string $code, Request $request): Response
    {
        $ticket = $this->ticketCatalog->findByCode($code);

        if ($ticket === null) {
            $this->logger->warning('Se solicitó una incidencia no existente', [
                'ticket_code' => $code,
                'route' => 'app_ticket_show',
            ]);

            throw $this->createNotFoundException('No existe la incidencia');
        }

        $request->getSession()->set('last_ticket_code', $ticket->getCode());

        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
            'responseTargetHours' => $this->slaCalculator->getResponseTargetHours($ticket),
        ]);
    }
}
