<?php

namespace App\Controller;

use PharIo\Manifest\Requirement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/order/{maVar}', name: 'test.order.route')]
    public function TestOrderRoute($maVar)
    {
        return new Response("
        <html><body><h1>$maVar</h1></body></html>
        ");
    }

    #[Route('/home', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'Name' => 'Mekhelian',
            'FirstName' => 'Gautier'
        ]);
    }

    #[Route('/SayHello/{name}/{firstname}', name: 'say_hello')]
    public function SayHello(Request $request, $name, $firstname): Response
    {
        return $this->render(
            '/home/hello.html.twig',
            [
                'nom' => $name,
                'prenom' => $firstname
            ]
        );
    }

    #[Route(
        '/multi/{entier1}/{entier2}',
        name: 'multiplication',
        requirements: ['entier1' => '\d+', 'entier2' => '\d+']
    )]
    public function Multiplication($entier1, $entier2): Response
    {
        $resultat = $entier1 * $entier2;
        return new Response("<h1>$resultat</h1>");
    }
}
