<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();

        if (!$session->has('todos')) {
            $todo = [
                'achat' => "Acheter du pain",
                'Cours' => "Réviser CCTL",
                'Perso' => "Vider ma poubelle"
            ];
            $session->set('todos', $todo);
            $this->addFlash('info', "Liste intialisée");
        }

        return $this->render('todo/index.html.twig', [
            'controller_name' => 'TodoController',
        ]);
    }

    #[Route('/todo/add/{name}/{content}', name: 'todo.add')]
    public function addTodo(Request $request, $name, $content): RedirectResponse
    {
        $session = $request->getSession();
        //Verifier si on a deja la liste existe
        if ($session->has('todos')) {
            //Verifier si on a deja un objet avec le meme name
            $todos = $session->get('todos');
            if (isset($todos[$name])) {
                $this->addFlash('danger', "le todo d'id '$name' existe deja dans la liste");
            } else {
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash('success', "le todo d'id '$name' a été ajouté");
            }
        } else {
            // Appeller le controller index
            $this->addFlash('error', "La liste n'existe pas encore");
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/todo/update/{name}/{content}', name: 'todo.update')]
    public function updateTodo(Request $request, $name, $content): RedirectResponse
    {
        $session = $request->getSession();
        //Verifier si on a deja la liste existe
        if ($session->has('todos')) {
            //Verifier si on a deja un objet avec le meme name
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                $this->addFlash('danger', "le todo d'id '$name' n'existe pas dans la liste");
            } else {
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash('success', "le todo d'id '$name' a été modifié");
            }
        } else {
            // Appeller le controller index
            $this->addFlash('error', "La liste n'existe pas encore");
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/todo/delete/{name}', name: 'todo.delete')]
    public function deleteTodo(Request $request, $name): RedirectResponse
    {
        $session = $request->getSession();
        //Verifier si on a deja la liste existe
        if ($session->has('todos')) {
            //Verifier si on a deja un objet avec le meme name
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                $this->addFlash('danger', "le todo d'id '$name' n'existe pas dans la liste");
            } else {
                unset($todos[$name]);
                $session->set('todos', $todos);
                $this->addFlash('success', "le todo d'id '$name' a été supprimé");
            }
        } else {
            // Appeller le controller index
            $this->addFlash('error', "La liste n'existe pas encore");
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/todo/reset', name: 'todo.reset')]
    public function resetTodo(Request $request): RedirectResponse
    {
        $session = $request->getSession();
        //Verifier si on a deja la liste existe
        $session->remove('todos');
        return $this->redirectToRoute('todo');
    }
}
