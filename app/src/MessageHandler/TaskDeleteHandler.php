<?php

namespace App\MessageHandler;

use App\Message\TaskDeleteMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class TaskDeleteHandler implements MessageHandlerInterface
{
    private $entityManager_;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->entityManager_ = $manager;
    }

    public function __invoke(TaskDeleteMessage $taskMessage)
    {
        $task = $this->entityManager_->getRepository(Task::class)->find($taskMessage->getId());
        $this->entityManager_->remove($task);
        $this->entityManager_->flush();
    }

}