<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creation_timeÑstamp;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $completion_timestamp;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_done;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreationTimeÑstamp(): ?\DateTimeInterface
    {
        return $this->creation_timeÑstamp;
    }

    public function setCreationTimeÑstamp(\DateTimeInterface $creation_timeÑstamp): self
    {
        $this->creation_timeÑstamp = $creation_timeÑstamp;

        return $this;
    }

    public function getCompletionTimestamp(): ?\DateTimeInterface
    {
        return $this->completion_timestamp;
    }

    public function setCompletionTimestamp(?\DateTimeInterface $completion_timestamp): self
    {
        $this->completion_timestamp = $completion_timestamp;

        return $this;
    }

    public function getIsDone(): ?bool
    {
        return $this->is_done;
    }

    public function setIsDone(bool $is_done): self
    {
        $this->is_done = $is_done;

        return $this;
    }
}
