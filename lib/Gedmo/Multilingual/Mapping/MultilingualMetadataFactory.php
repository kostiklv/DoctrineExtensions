<?php

namespace Gedmo\Multilingual\Mapping;

class MultilingualMetadataFactory extends \Doctrine\ORM\Mapping\ClassMetadataFactory
{
    protected function newClassMetadataInstance($className)
    {
        return new MultilingualClassMetadata($className);
    }
}