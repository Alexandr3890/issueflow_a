<?php

declare(strict_types=1);

namespace App\Form\Model;

use App\Entity\Category;
use App\Entity\User;
use App\Model\TicketPriority;
use App\Model\TicketStatus;

/**
 * Almacena los criterios de búsqueda de incidencias.
 *
 * Este objeto recibe los datos del formulario de filtros.
 */
final class TicketSearchCriteria
{
    // Texto para buscar por código o título.
    public ?string $query = '';

    // Prioridad seleccionada.
    public ?TicketPriority $priority = null;

    // Estado seleccionado.
    public ?TicketStatus $status = null;

    // Categoría seleccionada.
    public ?Category $category = null;

    // Usuario responsable de la incidencia.
    public ?User $assignee = null;
}
