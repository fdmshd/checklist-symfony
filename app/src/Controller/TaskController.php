<?php

namespace App\Controller;

use App\Entity\Task;
use App\Service\NormalizeService;
use DateTime;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="getListOfTasks",methods={"GET"})
     */
    public function getListOfTasks(): Response
    {
        $tasks = $this->getDoctrine()
            ->getRepository(Task::class)
            ->findAll();
        return new Response($this->json(['data' => $tasks]), 200);
    }

    /**
     * @Route ("/tasks/{id}", name = "change_completion_mark", requirements = {"id"="\d+"},methods={"POST"})
     */
    public function changeCompletionMark($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);
        $task->setIsDone(!$task->getIsDone());
        if ($task->getIsDone()) {
            $task->setCompletionTimestamp(new DateTime());
        }
        $entityManager->flush();
        return new Response($this->json(['message' => "completion mark successfully changed"]), 200);
    }

    /**
     * @Route("/tasks/{id}", name="getTask",requirements={"id"="\d+"},methods={"GET"})
     */
    public function getTask($id): Response
    {
        $task = $this->getDoctrine()
            ->getRepository(Task::class)
            ->find($id);
        return new Response($this->json(['data' => $task]), 200);
    }

    /**
     * @Route("/tasks/create", name="create_task",methods={"POST"})
     */
    public function createTask(Request $request, ValidatorInterface $validator, LoggerInterface $logger): Response
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
        $data = (new NormalizeService())->normalizeByGroup($task);

        return new Response($this->json(['message' => "task successfully created", 'data' => $data]), 201);
    }

    /**
     * @Route("/tasks/{id}", name="tasks_list",requirements={"id"="\d+"},methods={"PUT"})
     */
    public function updateTask(Request $request, $id, ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $decodedRequest = json_decode($request->getContent());
        $task = $entityManager->getRepository(Task::class)->find($id);
        if (!$task) {
            return new Response($this->json(['message' => "No task found for id .$id"]), 404);
        }
        $task->setTitle($decodedRequest->title);
        $task->setDescription($decodedRequest->description);
        $errors = $validator->validate($task);
        if (count($errors) > 0) {
            $errorsString = (string)$errors;
            return new Response($errorsString);
        }
        $entityManager->flush();
        return new Response($this->json(['message' => "task successfully updated", 'data' => $task]), 200);
    }

    /**
     * @Route("/tasks/{id}", name="task_delete",requirements={"id"="\d+"},methods={"DELETE"})
     */
    public function deleteTask($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);
        $entityManager->remove($task);
        $entityManager->flush();
        return new Response($this->json(['message' => "task successfully removed"]), 200);
    }
}
