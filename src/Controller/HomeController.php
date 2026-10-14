<?php 
// Verificamos estrictamente los tipos de las variables 
declare(strict_types=1);

// Agregamos el controlador namespace correpondiente, para que symfony lo tenga registrado */
namespace App\Controller;

// Creamos la clase correspondiente a nuestro controlador
// tiene el mismo nombre que el archivo src/Controller
// usamos el modificador final para que nadie herede de ella */
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;






final class HomeController {
   /* Agregamos al controlador la ruta de pagina de inicio */
// 
//Importamos la clase Route de symfony para definir rutas */

#[Route('/', name: 'app_home', methods: ['GET'])]
public function index(): Response { 
$projectName = 'IssueFlow';
$message = 'Symfony ha recibido la peticion y ha devuelto una respuesta';
$html = <<<HTML

            <!DOCTYPE html>

            <html lang="es">

            <head>

                <meta charset="UTF-8">

                <meta name="viewport" content="width=device-width, initial-scale=1.0">

                <title>{$projectName}</title>

            </head>

            <body>

                <main>

                    <h1>{$projectName}</h1>

                    <p>{$message}</p>

                    <p><a href="/tickets">Ver incidencias</a></p>

                    <p><a href="/health">Comprobar estado</a></p>

                </main>

            </body>

            </html>

        HTML;

        /* Devolvemos el objeto Response con $html como cuerpo (body) y un codigo 200 (OK)
        Usamos la constante Response::HTTP_OK que corresponde a 200 para que el codigo sea mas declarativo */

        return new Response ($html, 200);
}



}

