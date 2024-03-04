<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "content is required")]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    // #[Assert\NotBlank(message: "date is required")]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    #[Assert\Range(
        notInRangeMessage: 'likes must be between {{ min }} and {{ max }}',
        invalidMessage: 'likes must be a number',
        min: 0,
        max: 5
    )]    private ?int $likes = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?Blog $blog = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): static
    {
        $this->likes = $likes;

        return $this;
    }

    public function getBlog(): ?Blog
    {
        return $this->blog;
    }

    public function setBlog(?Blog $blog): static
    {
        $this->blog = $blog;

        return $this;
    }

    public function incrementLikes(): void
    {
        $this->likes++;
    }

}
