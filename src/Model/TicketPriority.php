<?php

declare(strict_types=1);

namespace App\Model;

/*
 Prioridades permitidas por el IssueFlow

 El sistema permita solo cuatro prioridades: 'Urgent',
 'high', 'normal', 'low'

 */

 enum TicketPriority: string 
 {

 case Urgent = 'urgent';
 case High = 'high';
 case Normal = 'normal';
 case Low = 'low';

 /* un enum tambien puede tener metodos.
 implementamos ell metodo getLabel{} para asignar el texto que se quiere mostar al usuario
 */
public function getLabel(): string
{

return match ($this) {
self::Urgent => 'Urgente',
self::High => 'Alta',
self::Normal => 'Normal',
self::Low => 'Baja'
};

}

 }