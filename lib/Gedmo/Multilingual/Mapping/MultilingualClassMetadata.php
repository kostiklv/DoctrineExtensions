<?php

namespace Gedmo\Multilingual\Mapping;

use Gedmo\Multilingual\Reflection\MultilingualEntityReflectionClass;

class MultilingualClassMetadata extends \Doctrine\ORM\Mapping\ClassMetadata
{
    public function __construct($entityName)
    {
        parent::__construct($entityName); // do not use $entityName, possible case-problems
        $this->reflClass = new MultilingualEntityReflectionClass($entityName);
        $this->namespace = $this->reflClass->getNamespaceName();
        $this->table['name'] = $this->reflClass->getShortName();
    }

    public function __wakeup()
    {
       // Restore ReflectionClass and properties
       $this->reflClass = new MultilingualEntityReflectionClass($this->name);

       foreach ($this->fieldMappings as $field => $mapping) {
           $reflField = isset($mapping['declared']) ? new MultilingualEntityReflectionClass($mapping['declared'], $field) :
               $this->reflClass->getProperty($field);

           $reflField->setAccessible(true);
           $this->reflFields[$field] = $reflField;
       }

       foreach ($this->associationMappings as $field => $mapping) {
           $reflField = isset($mapping['declared']) ? new MultilingualEntityReflectionClass($mapping['declared'], $field) :
               $this->reflClass->getProperty($field);

           $reflField->setAccessible(true);
           $this->reflFields[$field] = $reflField;
       }
    }
}