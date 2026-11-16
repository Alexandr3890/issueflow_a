<?php

declare(strict_types=1);

namespace App\Contract;

use App\Entity\Ticket;
use App\Form\Model\TicketSearchCriteria;
use Doctrine\ORM\Tools\Pagination\WindowPage;

/*
    Contrato que define que necesita mi aplicaci├│n de cualquier cat├ílogo
    de tickets.
    La interfaz describe que operaciones deben existir, pero no como se llevan
    a cabo.
*/
interface TicketCatalogInterface
{
    /* M├⌐todo que devuelva un array con todas las incidencias */
    public function getTickets(): array;

    /* M├⌐todo que devuelve un listado de incidencias dado unos criterios de b├║squeda */
    public function search(TicketSearchCriteria $criteria, int $page, int $pageSize): WindowPage;

    /* M├⌐todo que busca una incidencia en el listado seg├║n un
    code proporcionado, y que devuelva null si no existe */
    public function findByCode(string $code): ?Ticket;
}
