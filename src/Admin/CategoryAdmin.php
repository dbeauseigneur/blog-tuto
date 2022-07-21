<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoryAdmin extends AbstractAdmin
{
	protected function configureFormFields(FormMapper $form): void
	{
		$form->add('categoryName', TextType::class, ['label' => 'catégorie']);
	}

	protected function configureDatagridFilters(DatagridMapper $filter): void
	{
		$filter->add('categoryName');
	}

	protected function configureListFields(ListMapper $list): void
	{
		$list->addIdentifier('id')
			->addIdentifier('categoryName', 'string', ['label' => 'Catégorie']);
	}

	protected function configureShowFields(ShowMapper $show): void
	{
		$show->add('categoryName');
	}
}