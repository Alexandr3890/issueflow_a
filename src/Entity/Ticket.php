<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\TicketPriority;
use App\Model\TicketStatus;
use App\Repository\TicketRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * Entity Doctrine de una incidencia de IssueFlow.
 * Sigue siendo un objeto PHP pero le añadiremos
 * el mapeo necesario para que Doctrine sepa cómo
 * persistirlo en la base de datos.
 */
#[ORM\Entity(repositoryClass: TicketRepository::class)]
#[ORM\Table(name: 'tickets')]
final class Ticket
{
    /**
     * Identificador técnico (id) de base de datos.
     * Comienza con un valor null porque una entidad recién
     * creada aún no ha sido insertada.
     * El valor de id será asignado al momento de persistirla.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    private ?int $id = null;

    /**
     * Ticket es el lado propietario de la relación
     * porque la FK assignee_id vive en la tabla de tickets.
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?User $assignee = null;

    /**
     * Ticket es el lado propietario de la relación
     * porque la FK category_id vive en la tabla de tickets.
     * Category::$tickets es el lado inverso.
     */
    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Category $category = null;

    /*
     * Constructor Property Promotion (PHP moderno).
     */
    public function __construct(
        #[ORM\Column(length: 8, unique: true)]
        private readonly string $code,

        #[ORM\Column(length: 180)]
        private string $title,

        #[ORM\Column(length: 20, enumType: TicketPriority::class)]
        private TicketPriority $priority,

        #[ORM\Column(length: 20, enumType: TicketStatus::class)]
        private TicketStatus $status
    ) {
        /*
         * Validar el formato de code: INC- seguido de cuatro dígitos.
         */
        if (preg_match('/^INC-\d{4}$/', $this->code) !== 1) {
            throw new InvalidArgumentException('El código no tiene un formato válido');
        }

        /*
         * Normalización de title: eliminar espacios en blanco
         * antes y después.
         */
        $normalizedTitle = trim($title);

        if ($normalizedTitle === '') {
            throw new InvalidArgumentException('El título no puede estar vacío');
        }

        $this->title = $normalizedTitle;
    }

    /*
     * Getters para los atributos.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPriority(): TicketPriority
    {
        return $this->priority;
    }

    public function getStatus(): TicketStatus
    {
        return $this->status;
    }

    // Permite modificar el título de una incidencia
    public function setTitle(string $title): void
    {
        $normalizedTitle = trim($title);

        if ($normalizedTitle === '') {
            throw new InvalidArgumentException('El título no puede estar vacío');
        }

        $this->title = $normalizedTitle;
    }

    // Permite modificar la prioridad de una incidencia
    public function setPriority(TicketPriority $priority): void
    {
        $this->priority = $priority;
    }

    // Permite modificar el estado de una incidencia
    public function setStatus(TicketStatus $status): void
    {
        $this->status = $status;
    }

    // Desde Ticket puedo ver su assignee
    public function getAssignee(): ?User
    {
        return $this->assignee;
    }

    // Desde Ticket puedo ver su category
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    // Setters para los atributos de las relaciones

    // Asignamos un usuario a un ticket
    public function assignTo(?User $assignee): void
    {
        $this->assignee = $assignee;
    }

    // Asignamos una categoría a un ticket
    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    /*
     * Método que devuelve true si el ticket tiene una
     * prioridad 'urgent', y false en caso contrario.
     */
    public function isUrgent(): bool
    {
        return $this->priority->isUrgent();
    }

    /*
     * Método que devuelve true si una incidencia está cerrada.
     */
    public function isClosed(): bool
    {
        return $this->status->isClosed();
    }
}
