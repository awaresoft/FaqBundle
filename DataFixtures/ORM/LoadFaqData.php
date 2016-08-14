<?php

namespace Awaresoft\FaqBundle\DataFixtures\ORM;

use Application\FaqBundle\Entity\Faq;
use Awaresoft\Doctrine\Common\DataFixtures\AbstractFixture as AwaresoftAbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Awaresoft\SettingBundle\Entity\Setting;
use Awaresoft\SettingBundle\Entity\SettingHasFields;

/**
 * Class LoadFaqData
 *
 * @author Bartosz Malec <b.malec@awaresoft.pl>
 */
class LoadFaqData extends AwaresoftAbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 12;
    }

    /**
     * {@inheritDoc}
     */
    public function getEnvironments()
    {
        return array('dev', 'prod');
    }

    /**
     * {@inheritDoc}
     */
    public function doLoad(ObjectManager $manager)
    {
        $this->loadFaqs($manager);
        $this->loadSettings($manager);
    }

    protected function loadFaqs(ObjectManager $manager)
    {
        $object = new Faq();
        $object->setName('test');
        $object->setEnabled(true);
        $object->setSite($this->getReference('page-site'));
        $manager->persist($object);

        $object = new Faq();
        $object->setName('test2');
        $object->setEnabled(true);
        $object->setSite($this->getReference('page-site'));
        $manager->persist($object);

        $manager->flush();
    }

    protected function loadSettings(ObjectManager $manager)
    {
        $setting = new Setting();
        $setting
            ->setName('FAQ')
            ->setEnabled(false)
            ->setHidden(true)
            ->setInfo('Faq global parameters.');
        $manager->persist($setting);

        $settingField = new SettingHasFields();
        $settingField->setSetting($setting);
        $settingField->setName('MAX_DEPTH');
        $settingField->setValue('1');
        $settingField->setInfo('Set max depth for faq items. If you want to specific max depth for selected faq, please add option MAX_DEPTH_[FAQ_NAME]');
        $settingField->setEnabled(false);
        $manager->persist($settingField);

        $manager->flush();
    }
}
