<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class PostAdmin extends AbstractAdmin
{
	protected function configureFormFields(FormMapper $form): void
	{
		$form->add('title', TextType::class, ['label' => 'titre'])
			->add('content', CKEditorType::class,
				[
					'label' => 'contenu',
				]);
	}

	protected function configureDatagridFilters(DatagridMapper $filter): void
	{
		$filter->add('title');
	}

	protected function configureListFields(ListMapper $list): void
	{
		$list->addIdentifier('id')
			->addIdentifier('title', 'string', ['label' => 'titre']);
	}

	protected function configureShowFields(ShowMapper $show): void
	{
		$show->add('title');
	}
}