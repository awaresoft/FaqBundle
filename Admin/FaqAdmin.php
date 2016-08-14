<?php

namespace Awaresoft\FaqBundle\Admin;

use Application\FaqBundle\Entity\Faq;
use Awaresoft\TreeBundle\Admin\AbstractTreeAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

/**
 * Class FaqAdmin
 *
 * @author Bartosz Malec <b.malec@awaresoft.pl>
 */
class FaqAdmin extends AbstractTreeAdmin
{
    /**
     * @inheritdoc
     */
    protected $baseRoutePattern = 'awaresoft/faq/faq';

    /**
     * @inheritdoc
     */
    protected $multisite = true;

    /**
     * @inheritdoc
     */
    protected $titleField = 'name';

    /**
     * @inheritdoc
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
    }

    /**
     * @inheritdoc
     *
     * @param Menu $object
     */
    public function prePersist($object)
    {
        if ($object->getParent() && $object->getParent()->getSite() !== $object->getSite()) {
            $object->setSite($object->getParent()->getSite());
        }
    }

    /**
     * @inheritdoc
     *
     * @param Menu $object
     */
    public function preUpdate($object)
    {
        $this->prePersist($object);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('site')
            ->add('parent')
            ->add('content')
            ->add('voteUp')
            ->add('voteDown')
            ->add('visits')
            ->add('enabled');
    }

    protected function configureListFieldsExtend(ListMapper $listMapper)
    {
        $listMapper
            ->add('site')
            ->add('enabled', null, array('editable' => true))
            ->add('votes');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->prepareFilterMultisite($datagridMapper);

        $datagridMapper
            ->add('name')
            ->add('parent')
            ->add('level')
            ->add('enabled');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /**
         * @var Faq $object
         */
        $object = $this->getSubject();
        $maxDepthLevel = $this->prepareMaxDepthLevel('FAQ');

        $formMapper
            ->with($this->trans('admin.admin.form.group.main'), array('class' => 'col-md-6'))->end()
            ->with($this->trans('admin.admin.form.group.content'), array('class' => 'col-md-6'))->end();

        $formMapper
            ->with($this->trans('admin.admin.form.group.main'))
            ->add('name')
            ->add('enabled', null, array(
                'required' => false,
            ))
            ->add('visits', null, array(
                'disabled' => true,
            ));

        if ($this->hasSubject() && !$object->getId()) {
            $formMapper
                ->add('site', null, array('required' => true, 'read_only' => true));
        }

        $this->addParentField($formMapper, $maxDepthLevel, $object->getSite());

        $formMapper
            ->end();

        $formMapper
            ->with($this->trans('admin.admin.form.group.content'))
            ->add('content', 'sonata_formatter_type', array(
                'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                'format_field' => 'contentFormatter',
                'source_field' => 'rawContent',
                'source_field_options' => array(
                    'horizontal_input_wrapper_class' => $this->getConfigurationPool()->getOption('form_type') == 'horizontal' ? 'col-lg-12' : '',
                    'attr' => array('class' => $this->getConfigurationPool()->getOption('form_type') == 'horizontal' ? 'span10 col-sm-10 col-md-10' : '', 'rows' => 20)
                ),
                'ckeditor_context' => 'default',
                'target_field' => 'content',
                'listener' => true,
                'required' => false,
            ))
            ->end();
    }
}
