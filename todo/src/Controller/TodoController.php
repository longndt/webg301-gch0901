<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\TodoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
   // SELECT * FROM Todo
   #[Route('/' ,name: 'todo_index')]
   public function viewAllTodo() {
      $todo = $this->getDoctrine()->getRepository(Todo::class)->findAll();
      return $this->render('todo/index.html.twig',
                            [
                                'todos' => $todo
                            ]);
   }

   // SELECT * FROM Todo WHERE id = '$id'
   #[Route('/detail/{id}', name: 'todo_detail')]
   public function viewTodoById ($id) {
       $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);
       return $this->render("todo/detail.html.twig",
                            [
                                'todo' => $todo
                            ]);
   }

   // DELETE FROM Todo WHERE id = '$id'
   #[Route('/delete/{id}', name: 'todo_delete')]
   public function deleteTodo ($id) {
        $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($todo);
        $manager->flush();
        //gửi flash message về view
        $this->addFlash("Info","Delete Todo succeed !");
        return $this->redirectToRoute("todo_index");
   }

   // INSERT INTO Todo ....
   #[Route('/add', name: 'todo_add')]
   public function addTodo (Request $request) {
        $todo = new Todo;
        $form = $this->createForm(TodoType::class,$todo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($todo);
            $manager->flush();
            $this->addFlash("Info","Add Todo succeed !");
            return $this->redirectToRoute("todo_index");
        }
        return $this->renderForm('todo/add.html.twig',
                                [
                                    'todoForm' => $form
                                ]);
   }

   // UPDATE Todo SET .... WHERE ....
   #[Route('/edit/{id}', name: 'todo_edit')]
   public function editTodo (Request $request, $id) {
        $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);
        $form = $this->createForm(TodoType::class,$todo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($todo);
            $manager->flush();
            $this->addFlash("Info","Edit Todo succeed !");
            return $this->redirectToRoute("todo_index");
        }
        return $this->renderForm('todo/edit.html.twig',
                                [
                                    'todoForm' => $form
                                ]);

   }
}
