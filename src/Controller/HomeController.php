<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'projectName' => 'IssueFlow',
            'message' => 'Symfony ha recibido la peticion y ha devuelto una respuesta',
        ]);
    }

    #[Route('/health', name: 'app_health', methods: ['GET'])]
    public function health(): Response
    {
        $html = '
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <title>Saludo</title>
            </head>
            <body>
                <h1>IssueFlow OK</h1>
            </body>
            </html>
        ';

        return new Response(
            $html,
            Response::HTTP_OK,
            ['Content-Type' => 'text/html']
        );
    }
}