<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
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
}
