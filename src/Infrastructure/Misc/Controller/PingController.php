<?php

namespace App\Infrastructure\Global\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PingController
{
    #[Route('/', methods: ['GET'])]
    public function ping(): Response
    {
        return new Response('Pong!', Response::HTTP_OK);
    }

}
