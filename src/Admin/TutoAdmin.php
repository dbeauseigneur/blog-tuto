<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\BooleanType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\String\Slugger\AsciiSlugger;

class TutoAdmin extends AbstractAdmin
{
	protected function configureFormFields(FormMapper $form): void
	{
		$form->add('name', TextType::class, ['label' => 'titre'])
			->add('url', TextType::class, ['label' => 'nom du lien', 'required' => false])
			->add('describeContent', CKEditorType::class,
				[
					'label' => 'contenu',
				])
			->add('published', CheckboxType::class, ['required' => false]);
	}

	protected function preValidate(object $object): void
	{
		parent::preValidate($object);

		if (!$object->getDate() && $object->isPublished()) {
			$object->setDate(new \DateTime());
		}
	}

	protected function configureDatagridFilters(DatagridMapper $filter): void
	{
		$filter->add('name');
	}

	protected function configureListFields(ListMapper $list): void
	{
		$list->addIdentifier('id', null, ['route' => [
			'id' => 'edit'
		]])
			->addIdentifier('name', 'string', ['label' => 'titre'])
			//->add('Date',DateTimeType::class, ['format' => 'yyyy-MM-dd hh:mm'])
			->add('published');
	}

	protected function configureShowFields(ShowMapper $show): void
	{
		$show->add('name')
			->add('url')
			->add('describeContent', CKEditorType::class,
				[
					'label' => 'contenu',
				])
			//->add('Date',DateTimeType::class, ['format' => 'yyyy-MM-dd hh:mm'])
			->add('published', BooleanType::class);

	}
}