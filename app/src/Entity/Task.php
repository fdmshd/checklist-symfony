<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ("main")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups ("main")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups ("main")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups ("main")
     */
    private $creation_timestamp;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups ("main")
     */
    private $completion_timestamp;

    /**
     * @ORM\Column(type="boolean")
     * @Groups ("main")
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

    public function getCreationTimestamp(): ?\DateTimeInterface
    {
        return $this->creation_timestamp;
    }

    public function setCreationTimestamp(\DateTimeInterface $creation_timestamp): self
    {
        $this->creation_timestamp = $creation_timestamp;

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
