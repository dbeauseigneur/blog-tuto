<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	private int $id;

	#[ORM\Column(type: 'string', length: 255)]
	private ?string $title;

	#[ORM\Column(type: 'string', length: 255)]
	private ?string $link;

	#[ORM\Column(type: 'datetime', nullable: true)]
	private ?\DateTimeInterface $publicationDate;

	#[ORM\Column(type: 'text', nullable: true)]
	private ?string $content;

	#[ORM\Column(type: 'boolean', nullable: true)]
	private bool $openComment;

	#[ORM\Column(type: 'boolean', nullable: true)]
	private ?bool $status;

	#[ORM\OneToMany(mappedBy: 'postId', targetEntity: Comment::class)]
	private Collection $comments;

	#[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'posts')]
	private Collection $categories;

	public function __construct()
	{
		$this->comments = new ArrayCollection();
		$this->categories = new ArrayCollection();
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
		return $this->publicationDate;
	}

	public function setPublicationDate(?\DateTimeInterface $publicationDate): self
	{
		$this->publicationDate = $publicationDate;

		return $this;
	}

	public function getContent(): ?string
	{
		return $this->content;
	}

	public function setContent(?string $content): self
	{
		$this->content = $content;

		return $this;
	}

	public function isOpenComment(): ?bool
	{
		return $this->openComment;
	}

	public function setOpenComment(?bool $openComment): self
	{
		$this->openComment = $openComment;

		return $this;
	}

	public function isStatus(): ?bool
	{
		return $this->status;
	}

	public function setStatus(?bool $status): self
	{
		$this->status = $status;

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

	/**
	 * @return Collection<int, category>
	 */
	public function getCategories(): Collection
	{
		return $this->categories;
	}

	public function addCategory(category $category): self
	{
		if (!$this->categories->contains($category)) {
			$this->categories[] = $category;
		}

		return $this;
	}

	public function removeCategory(category $category): self
	{
		$this->categories->removeElement($category);

		return $this;
	}

}
