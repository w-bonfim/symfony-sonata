<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Category;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Form\Type\CheckBoxType;

final class BlogPostAdmin extends AbstractAdmin
{
    public function toString($object)
    {
        return $object instanceof BlogPost
            ? $object->getTitle()
            : 'Blog Post'; // shown in the breadcrumb on the create view
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('Content')
                        ->add('title', TextType::class)
                        ->add('body', TextareaType::class)
                        ->add('draft', 'checkbox')
                    ->end()
                    ->with('Meta data')
                        ->add('category', ModelType::class, [
                            'class' => Category::class,
                            'property' => 'name',
                        ])
                    ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title')
                        ->add('category', null, [], EntityType::class, [
                            'class' => Category::class,
                            'choice_label' => 'name',
                        ]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title')
                    ->add('draft');
    }
}