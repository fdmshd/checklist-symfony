<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="tasks_list",requirements={"id"="\d+"},methods={"GET"})
     */
    public function getListOfTasks(): Response
    {
        $tasks = $this->getDoctrine()
            ->getRepository(Task::class)
            ->findAll();
        return new Response($this->json(['data'=>$tasks]), 200);
    }
    /**
     * @Route("/tasks/{id}", name="get_task",requirements={"id"="\d+"},methods={"GET"})
     */
    public function getTask($id): Response
    {
        $task = $this->getDoctrine()
            ->getRepository(Task::class)
            ->find($id);
        return new Response($this->json(['data'=>$task]), 200);
    }

    /**
     * @Route("/tasks", name="tasks_list",requirements={"id"="\d+"},methods={"GET"})
     */
    public function createTask(): Response
    {
        $tasks = $this->getDoctrine()
            ->getRepository(Task::class)
            ->findAll();
        return new Response($this->json(['data'=>$tasks]), 200);
    }

}
