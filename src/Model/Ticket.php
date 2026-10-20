<?php

declare(strict_types=1);

namespace App\Model;

/*
 * Ticket representa una incidencia en IssueFlow
 * como un objeto PHP
 */
final class Ticket
{
    private string $id;
    private string $title;
    private string $priority;
    private string $status;

    public function __construct(
        string $id,
        string $title,
        string $priority,
        string $status
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->priority = $priority;
        $this->status = $status;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}