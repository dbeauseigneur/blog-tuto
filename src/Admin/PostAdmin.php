<?php

namespace App\Admin;

use App\Entity\Category;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\String\Slugger\AsciiSlugger;

class PostAdmin extends AbstractAdmin
{
	protected function configureFormFields(FormMapper $form): void
	{
		$form->add('title', TextType::class, ['label' => 'titre'])
			->add('categories', EntityType::class,
				[
					'label' => 'catégories',
					'class' => Category::class,
					'choice_label' => 'categoryName',
					'multiple' => true,
					'expanded' => false,
				])
			->add('content', CKEditorType::class,
				[
					'label' => 'contenu',
				])
			->add('status', CheckboxType::class, ['required' => false])
			->add('openComment', CheckboxType::class, ['required' => false]);
	}

	protected function preValidate(object $object): void
	{
		parent::preValidate($object);
		$slugger = new AsciiSlugger();
		$object->setLink($slugger->slug($object->getTitle()));
		if (!$object->getPublicationDate() && $object->isStatus()) {
			$object->setPublicationDate(new \DateTime());
		}
	}

	protected function configureDatagridFilters(DatagridMapper $filter): void
	{
		$filter->add('title');
	}

	protected function configureListFields(ListMapper $list): void
	{
		$list->addIdentifier('id', null, ['route' => [
			'id' => 'edit'
		]])
			->addIdentifier('title', 'string', ['label' => 'titre'])
			->add('publicationDate')
			->add('status')
			->add('openComment');
	}

	protected function configureShowFields(ShowMapper $show): void
	{
		$show->add('title')
			->add('content', CKEditorType::class,
				[
					'label' => 'contenu',
				])
			->add('status', CheckboxType::class, ['required' => false])
			->add('openComment', CheckboxType::class, ['required' => false]);
	}
}