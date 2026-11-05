<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Controlador principal de IssueFlow.
 *
 * Gestiona la página de inicio y la ruta de comprobación
 * del estado de la aplicación.
 */
final class HomeController extends AbstractController
{
    /**
     * Muestra la página principal.
     */
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'projectName' => 'IssueFlow',
            'message' => 'Symfony ha recibido la petición y ha devuelto una respuesta',
        ]);
    }

    /**
     * Comprueba que la aplicación está funcionando.
     */
    #[Route('/health', name: 'app_health', methods: ['GET'])]
    public function health(): Response
    {
        return new Response(
            'IssueFlow OK',
            Response::HTTP_OK,
            ['Content-Type' => 'text/plain']
        );
    }

    /*
     * Ejercicio de clase:
     * Crear una ruta /saludo que devuelva un documento HTML
     * con un encabezado h1.
     *
     * No forma parte de las rutas definitivas de la aplicación.
     *
     * #[Route('/saludo', name: 'app_saludo', methods: ['GET'])]
     * public function saludo(): Response
     * {
     *     $html = '<h1>Hola a todos, este es mi saludo</h1>';
     *
     *     return new Response($html, Response::HTTP_OK);
     * }
     */
}