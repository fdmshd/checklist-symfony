<?php

namespace App\Controller;

use App\Message\TaskCreateMessage;
use App\Message\TaskDeleteMessage;
use App\Message\TaskUpdateMessage;
use App\Message\TaskCompleteMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class TaskQueueController extends AbstractController
{
    private $bus_;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus_ = $bus;
    }

    /**
     * @Route("/tasks/dispatch", name="task_queue_create", methods={"POST"})
     */
    public function dispatchCreateToQueue(Request $request): Response
    {
        $decodedRequest = json_decode($request->getContent());
        $this->bus_->dispatch(new TaskCreateMessage(
            $decodedRequest->title,
            $decodedRequest->description
        ));

        return $this->json([
            'message' => 'Create Task is send to queue',
        ]);
    }

    /**
     * @Route("/tasks/dispatch/{id}",name="task_queue_update",requirements={"id"="\d+"},methods={"PUT"})
     */
    public function dispatchUpdateToQueue(Request $request, $id): Response
    {
        $decodedRequest = json_decode($request->getContent());
        $this->bus_->dispatch(new TaskUpdateMessage(
            $id,
            $decodedRequest->title,
            $decodedRequest->description
        ));

        return $this->json([
            'message' => 'Update Task is send to queue',
        ]);
    }

    /**
     * @Route("/tasks/dispatch/{id}", name="task_queue_delete",requirements={"id"="\d+"},methods={"DELETE"})
     */
    public function dispatchDeleteToQueue($id): Response
    {
        $this->bus_->dispatch(new TaskDeleteMessage($id));

        return $this->json([
            'message' => 'Delete Task is send to queue',
        ]);
    }

    /**
     * @Route("/tasks/dispatch/{id}", name="task_queue_complete",requirements={"id"="\d+"},methods={"POST"})
     */
    public function dispatchCompleteToQueue($id): Response
    {
        $this->bus_->dispatch(new TaskCompleteMessage($id));
        return $this->json([
            'message' => 'Complete Task is send to queue',
        ]);
    }
}