<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseGallery;

/**
 * @ORM\Entity
 * @ORM\Table(name="media__gallery")
 */
class SonataMediaGallery extends BaseGallery
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	public function getId(): ?int
	{
		return $this->id;
	}
}
