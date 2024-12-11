<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: "integer")]
	private int $id;

	#[ORM\Column(type: 'string', length: 30)]
	private ?string $categoryName;

	#[ORM\Column(type: 'string', length: 30, nullable: true)]
	private ?string $slug;

	#[ORM\ManyToMany(targetEntity: Post::class, mappedBy: 'categories')]
	private Collection $posts;

	public function __construct()
	{
		$this->posts = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getCategoryName(): ?string
	{
		return $this->categoryName;
	}

	public function setCategoryName(string $categoryName): self
	{
		$this->categoryName = $categoryName;

		return $this;
	}

	public function getSlug(): ?string
	{
		return $this->slug;
	}

	public function setSlug(?string $slug): self
	{
		$this->slug = $slug;

		return $this;
	}

	/**
	 * @return Collection<int, Post>
	 */
	public function getPosts(): Collection
	{
		return $this->posts;
	}

	public function addPost(Post $post): self
	{
		if (!$this->posts->contains($post)) {
			$this->posts[] = $post;
			$post->addCategory($this);
		}

		return $this;
	}

	public function removePost(Post $post): self
	{
		if ($this->posts->removeElement($post)) {
			$post->removeCategory($this);
		}

		return $this;
	}
}
