<?php

namespace App\MessageHandler;

use App\Message\TaskUpdateMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class TaskUpdateHandler implements MessageHandlerInterface
{
    private $entityManager_;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->entityManager_ = $manager;
    }

    public function __invoke(TaskUpdateMessage $taskMessage)
    {
        $task = $this->entityManager_->getRepository(Task::class)->find($taskMessage->getId());
        $task->setTitle($taskMessage->getTitle());
        $task->setDescription($taskMessage->getDescription());
        $this->entityManager_->persist($task);
        $this->entityManager_->flush();
    }

}