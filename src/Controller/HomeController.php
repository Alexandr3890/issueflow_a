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
            'message' => 'Symfony ha recibido la petición y ha devuelto una respuesta',
        ]);
    }

    #[Route('/health', name: 'app_health', methods: ['GET'])]
    public function health(): Response
    {
        return new Response('IssueFlow OK', Response::HTTP_OK);
    }
}