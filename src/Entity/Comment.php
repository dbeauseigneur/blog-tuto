<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class Comment
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	private int $id;

	#[ORM\Column(type: 'string', length: 40)]
	private ?string $author;

	#[ORM\Column(type: 'string', length: 50)]
	private ?string $authorEmail;

	#[ORM\Column(type: 'string', length: 150, nullable: true)]
	private ?string $title;

	#[ORM\Column(type: 'text')]
	private ?string $content;

	#[ORM\Column(type: 'datetime')]
	private ?\DateTimeInterface $date;

	#[ORM\Column(type: 'boolean')]
	private ?bool $approved = false;

	#[ORM\Column(type: 'text', nullable: true)]
	private ?string $myAnswer;

	#[ORM\ManyToOne(targetEntity: Post::class, inversedBy: 'comments')]
	#[ORM\JoinColumn(nullable: false)]
	private ?Post $postId;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getAuthor(): ?string
	{
		return $this->author;
	}

	public function setAuthor(string $author): self
	{
		$this->author = $author;

		return $this;
	}

	public function getAuthorEmail(): ?string
	{
		return $this->authorEmail;
	}

	public function setAuthorEmail(string $authorEmail): self
	{
		$this->authorEmail = $authorEmail;

		return $this;
	}

	public function getTitle(): ?string
	{
		return $this->title;
	}

	public function setTitle(?string $title): self
	{
		$this->title = $title;

		return $this;
	}

	public function getContent(): ?string
	{
		return $this->content;
	}

	public function setContent(string $content): self
	{
		$this->content = $content;

		return $this;
	}

	public function getDate(): ?\DateTimeInterface
	{
		return $this->date;
	}

	public function setDate(\DateTimeInterface $date): self
	{
		$this->date = $date;

		return $this;
	}

	public function isApproved(): ?bool
	{
		return $this->approved;
	}

	public function setApproved(bool $approved): self
	{
		$this->approved = $approved;

		return $this;
	}

	public function getMyAnswer(): ?string
	{
		return $this->myAnswer;
	}

	public function setMyAnswer(?string $myAnswer): self
	{
		$this->myAnswer = $myAnswer;

		return $this;
	}

	public function getPostId(): ?Post
	{
		return $this->postId;
	}

	public function setPostId(?Post $postId): self
	{
		$this->postId = $postId;

		return $this;
	}

	#[ORM\PrePersist]
	public function setDateValue(): void
	{
		$this->date = new \DateTime();
	}
}
