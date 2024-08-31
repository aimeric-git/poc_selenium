<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\NewTaskFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
        
    }

    #[Route('/', name: 'task_index')]
    public function index(): Response
    {
        $tasks = $this->em->getRepository(Task::class)->findAll();

        return $this->render('task/index.html.twig', [
            'tasks' =>  $tasks
        ]);
    }

    #[Route('/task/new', name: 'task_new')]
    public function new(Request $request): Response
    {
        $task = new Task();
        $form = $this->createForm(NewTaskFormType::class, $task);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($task);
            $this->em->flush();
            $this->addFlash('notice', 'Création réussie');

            return $this->redirectToRoute('task_index');
        }

        return $this->render('task/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/task/edit/{id}', name: 'task_edit')]
    public function edit(Request $request, $id): Response
    {
        $task = $this->em->getRepository(Task::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(NewTaskFormType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setTitle($form->getData()->getTitle());
            $task->setDescription($form->getData()->getDescription());
            $this->em->flush();
            $this->addFlash('notice', 'Modification avec succès');

            return $this->redirectToRoute('task_index');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/task/delete/{id}', name: 'task_delete')]
    public function delete(Request $request, $id): Response
    {
        $task = $this->em->getRepository(Task::class)->findOneBy(['id' => $id]);
        if($task){
            $this->em->remove($task);
            $this->em->flush();
            $this->addFlash('notice', 'Suppression avec succès');
        }else{
            $this->addFlash('error', 'La tache n\' existe pas');
        }

        return $this->redirectToRoute('task_index');
    }

    #[Route('/task/{id}', name: 'task_show')]
    public function show($id): Response
    {
        $task = $this->em->getRepository(Task::class)->findOneBy(['id' => $id]);
        return $this->render('task/show.html.twig', [
            'task' => $task
        ]);
    }

}
