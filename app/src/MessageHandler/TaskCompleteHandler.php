<?php

namespace App\MessageHandler;

use App\Message\TaskCompleteMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;

class TaskCompleteHandler implements MessageHandlerInterface
{
    private $entityManager_;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->entityManager_ = $manager;
    }

    public function __invoke(TaskCompleteMessage $taskMessage)
    {
        $task = $this->entityManager_->getRepository(Task::class)->find($taskMessage->getId());
        $task->setIsDone(!$task->getIsDone());
        if ($task->getIsDone()) {
            $task->setCompletionTimestamp(new DateTime());
        }
        $this->entityManager_->persist($task);
        $this->entityManager_->flush();
    }

}