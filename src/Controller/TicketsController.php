<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

final class TicketsController
{
    /* Mock data de tickets: Data simulada de prueba. La data real
    se obtendra luego de una peticion a la base de datos */

    
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
];
           


/* Crear la ruta/tickets que muestre el listado de todos los tickets
Por convencion se identifica con index a la ruta que muestra un listado del recurso
(en este caso tickets)
*/

#[Route('/tickets', name: 'app_ticket_index', methods: ['GET'])]
public function index(): Response
{
    $itemsList = '';

    foreach (self::TICKETS as $ticket) {
        $itemsList .= "<li>{$ticket['id']} - Título: {$ticket['title']} - Prioridad: {$ticket['priority']} - Estado: {$ticket['status']}</li>";
    }

    $total = count(self::TICKETS);

    $html = <<<HTML
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>IssueFlow - Incidencias</title>
        </head>

        <body>
            <main>
                <h1>Incidencias</h1>

                <p>Total: {$total}</p>

                <ul>
                    {$itemsList}
                </ul>

                <p><a href="/">Volver al inicio</a></p>
            </main>
        </body>

        </html>
    HTML;

    return new Response($html, Response::HTTP_OK);
}

}