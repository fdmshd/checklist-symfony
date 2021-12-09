<?php

namespace App\MessageHandler;

use App\Message\TaskCreateMessage;
use App\Service\NormalizeService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;

class TaskCreateHandler implements MessageHandlerInterface
{
    private $entityManager_;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->entityManager_ = $manager;
    }

    public function __invoke(TaskCreateMessage $taskMessage)
    {
        $task = new Task();
        $task->setTitle($taskMessage->getTitle());
        $task->setDescription($taskMessage->getDescription());
        $task->setCreationTimestamp(new DateTime());
        $task->setIsDone(false);
        $this->entityManager_->persist($task);
        $this->entityManager_->flush();
        $data = (new NormalizeService())->normalizeByGroup($task);
    }

}