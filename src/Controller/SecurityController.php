<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class SecurityController extends AbstractController
{
    /**
     * El POST será interceptado por el firewall de seguridad.
     * Symfony verificará las credenciales del usuario.
     * El GET mostrará el formulario de inicio de sesión.
     */
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Si el usuario ya está autenticado, lo enviamos al listado de tickets.
        if ($this->getUser() !== null) {
            return $this->redirectToRoute('app_ticket_index');
        }

        // Mostramos el formulario y enviamos los datos del último intento.
        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }
}