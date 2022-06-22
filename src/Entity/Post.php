<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $title;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $link;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $PublicationDate;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $Content;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $OpenComment;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $statut;

	/**
	 * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="postId")
	 */
	private $comments;

	public function __construct()
	{
		$this->comments = new ArrayCollection();
	}

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

	public function getLink(): ?string
	{
		return $this->link;
	}

	public function setLink(string $link): self
	{
		$this->link = $link;

		return $this;
	}

	public function getPublicationDate(): ?\DateTimeInterface
	{
		return $this->PublicationDate;
	}

	public function setPublicationDate(?\DateTimeInterface $PublicationDate): self
	{
		$this->PublicationDate = $PublicationDate;

		return $this;
	}

	public function getContent(): ?string
	{
		return $this->Content;
	}

	public function setContent(?string $Content): self
	{
		$this->Content = $Content;

		return $this;
	}

	public function isOpenComment(): ?bool
	{
		return $this->OpenComment;
	}

	public function setOpenComment(?bool $OpenComment): self
	{
		$this->OpenComment = $OpenComment;

		return $this;
	}

	public function isStatut(): ?bool
	{
		return $this->statut;
	}

	public function setStatut(?bool $statut): self
	{
		$this->statut = $statut;

		return $this;
	}

	/**
	 * @return Collection<int, Comment>
	 */
	public function getComments(): Collection
	{
		return $this->comments;
	}

	public function addComment(Comment $comment): self
	{
		if (!$this->comments->contains($comment)) {
			$this->comments[] = $comment;
			$comment->setPostId($this);
		}

		return $this;
	}

	public function removeComment(Comment $comment): self
	{
		if ($this->comments->removeElement($comment)) {
			// set the owning side to null (unless already changed)
			if ($comment->getPostId() === $this) {
				$comment->setPostId(null);
			}
		}

		return $this;
	}
}
