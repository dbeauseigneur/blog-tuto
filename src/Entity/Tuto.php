<?php

namespace App\Entity;

use App\Repository\TutoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TutoRepository::class)
 */
class Tuto
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=50)
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $url;

	/**
	 * @ORM\Column(type="text")
	 */
	private $describeContent;

	/**
	 * @ORM\Column(type="string", length=60, nullable=true)
	 */
	private $nameUrl;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $date;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $published;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	public function getUrl(): ?string
	{
		return $this->url;
	}

	public function setUrl(string $url): self
	{
		$this->url = $url;

		return $this;
	}

	public function getNameUrl(): ?string
	{
		return $this->nameUrl;
	}

	public function setNameUrl(?string $nameUrl): self
	{
		$this->nameUrl = $nameUrl;

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

	public function isPublished(): ?bool
	{
		return $this->published;
	}

	public function setPublished(bool $published): self
	{
		$this->published = $published;

		return $this;
	}

	/**
	 * @return ?string
	 */
	public function getDescribeContent(): ?string
	{
		return $this->describeContent;
	}

	/**
	 * @param ?string $describeContent
	 * @return Tuto
	 */
	public function setDescribeContent(?string $describeContent): self
	{
		$this->describeContent = $describeContent;
		return $this;
	}

}
