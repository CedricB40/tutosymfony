<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route(path: "/", name: "home")]
    public function index(Request $request): Response {
        // dump($request);
        // die;

        // return new Response("Hello ".$request->query->get("nom","World !!!"));
        return $this->render('home/index.html.twig');
    }
}
