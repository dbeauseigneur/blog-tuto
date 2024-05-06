<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class CommentAdmin
 * @package App\Admin
 */
class CommentAdmin extends AbstractAdmin
{
	// Fields to be shown on lists
	protected function configureListFields(ListMapper $list): void
	{
		$list
			->add('author', null, array(
				'label' => 'Auteur'
			))
			->add('authorEmail', null, array(
				'label' => 'E-mail'
			))
			->addIdentifier('content', null, array(
				'label' => 'Message'
			))
			->add('date', null, array(
				'label' => 'Date de publication'
			))
			->addIdentifier('approved', null, array(
				'label' => 'Approuver'
			));
	}

	// Fields to be modified in back office
	protected function configureFormFields(FormMapper $form): void
	{
		$form
			->add(
				'approved',
				CheckboxType::class,
				array(
					'label' => 'Valider ce commentaire',
					'required' => false
				)
			)
			->add(
				'content',
				TextareaType::class,
				array(
					'label' => 'Commentaire posté sur l\'article',
					'disabled' => true
				)
			)
			->add(
				'myAnswer',
				TextareaType::class,
				array(
					'label' => 'Répondre à ce commentaire',
					'required' => false
				)
			);
	}

	protected function configureRoutes(RouteCollectionInterface $collection): void
	{
		$collection->remove('create');
	}

}
