<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=30)
	 */
	private $categoryName;

	/**
	 * @ORM\Column(type="string", length=30, nullable=true)
	 */
	private $slug;

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
}
