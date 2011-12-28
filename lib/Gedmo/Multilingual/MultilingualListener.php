<?php

namespace Gedmo\Multilingual;
/**
 * Created by JetBrains PhpStorm.
 * User: Kostja
 * Date: 12/28/11
 * Time: 9:35 PM
 * To change this template use File | Settings | File Templates.
 */

use Doctrine\ORM\Events;
use Gedmo\Mapping\MappedEventSubscriber;

class MultilingualListener extends MappedEventSubscriber
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    function getSubscribedEvents()
    {
        return array(
            Events::loadClassMetadata
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function getNamespace()
    {
        return __NAMESPACE__;
    }

    function loadClassMetadata(\Doctrine\ORM\Event\LoadClassMetadataEventArgs $eventArgs)
    {
        $ea = $this->getEventAdapter($eventArgs);
        $this->loadMetadataForObjectClass($ea->getObjectManager(), $eventArgs->getClassMetadata());

        $classMetadata = $eventArgs->getClassMetadata();
        $className = $classMetadata->getName();

        if (!isset($this->configurations[$className]['multilingual']) || !$this->configurations[$className]['multilingual']) {
            // class is not multilingual - nothing to do
            return;
        }

        if ($classMetadata->getName() == 'Multilingual\Fixture\Person') {
            $fieldMapping = array(
                'fieldName' => 'name_ru',
                'type' => 'string',
                'length' => 50
            );
            $classMetadata->mapField($fieldMapping);
        }
    }
}