<?php

namespace App\Controller;

use App\Entity\TaskList;
use App\Form\TaskList1Type;
use App\Repository\TaskListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tasklist')]
class TasklistController extends AbstractController
{
    #[Route('/', name: 'tasklist_index', methods: ['GET'])]
    public function index(TaskListRepository $taskListRepository): Response
    {
        return $this->render('tasklist/index.html.twig', [
            'task_lists' => $taskListRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'tasklist_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $taskList = new TaskList();
        $form = $this->createForm(TaskList1Type::class, $taskList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($taskList);
            $entityManager->flush();

            return $this->redirectToRoute('tasklist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tasklist/new.html.twig', [
            'task_list' => $taskList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'tasklist_show', methods: ['GET'])]
    public function show(TaskList $taskList): Response
    {
        return $this->render('tasklist/show.html.twig', [
            'task_list' => $taskList,
        ]);
    }

    #[Route('/{id}/edit', name: 'tasklist_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TaskList $taskList, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TaskList1Type::class, $taskList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('tasklist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tasklist/edit.html.twig', [
            'task_list' => $taskList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'tasklist_delete', methods: ['POST'])]
    public function delete(Request $request, TaskList $taskList, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$taskList->getId(), $request->request->get('_token'))) {
            $entityManager->remove($taskList);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tasklist_index', [], Response::HTTP_SEE_OTHER);
    }
}
