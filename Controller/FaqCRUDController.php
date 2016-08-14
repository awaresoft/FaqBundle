<?php

namespace Awaresoft\FaqBundle\Controller;

use Awaresoft\Sonata\AdminBundle\Controller\CRUDController as AwaresoftCRUDController;
use Awaresoft\Sonata\AdminBundle\Traits\ControllerHelperTrait;

/**
 * Class FaqCRUDController
 *
 * @author Bartosz Malec <b.malec@awaresoft.pl>
 */
class FaqCRUDController extends AwaresoftCRUDController
{
    use ControllerHelperTrait;

    /**
     * @inheritdoc
     */
    public function preDeleteAction($object)
    {
        $message = $this->checkObjectIsBlocked($object, $this->admin);

        return $message;
    }

    /**
     * @inheritdoc
     */
    public function batchActionDeleteIsRelevant(array $idx)
    {
        $message = null;

        foreach ($idx as $id) {
            $object = $this->admin->getObject($id);
            $message = $this->checkObjectIsBlocked($object, $this->admin);
        }

        if (!$message) {
            return true;
        }

        return $message;
    }
}
