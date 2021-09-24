<?php

namespace App\Controller;

use App\Entity\Task;
use DateTime;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
        return new Response($this->json(['data' => $tasks]), 200);
    }

    /**
     * @Route("/tasks/{id}", name="get_task",requirements={"id"="\d+"},methods={"GET"})
     */
    public function getTask($id): Response
    {
        $task = $this->getDoctrine()
            ->getRepository(Task::class)
            ->find($id);
        return new Response($this->json(['data' => $task]), 200);
    }

    /**
     * @Route("/tasks", name="create_task",methods={"POST"})
     */
    public function createTask(Request $request, ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $decodedRequest = json_decode($request->getContent());
        $task = new Task();
        $task->setTitle($decodedRequest->title);
        $task->setDescription($decodedRequest->description);
        $task->setCreationTimestamp(new DateTime());
        $task->setIsDone(false);
        $errors = $validator->validate($task);
        if (count($errors) > 0) {
            $errorsString = (string)$errors;
            return new Response($errorsString);
        }
        $entityManager->persist($task);
        $entityManager->flush();
        return new Response($this->json(['message' => "Task created successfully", 'data' => $task]), 201);
    }

    /**
     * @Route("/tasks/{id}", name="tasks_list",requirements={"id"="\d+"},methods={"GET"})
     */
    public function updateTask(Request $request, $id, ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $decodedRequest = json_decode($request->getContent());
        $task = $entityManager->getRepository(Task::class)->find($id);
        if (!$task) {
            return new Response($this->json(['message' => " No task found for id .$id"]), 404);
        }
        $task->setTitle($decodedRequest->title);
        $task->setDescription($decodedRequest->description);
        $errors = $validator->validate($task);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new Response($errorsString);
        }
        $entityManager->flush();
        return new Response($this->json(['message' => " 'No task found for id '.$id", 'data' => $task]), 201);
    }
}
