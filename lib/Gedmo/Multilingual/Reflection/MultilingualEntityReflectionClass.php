<?php

namespace Gedmo\Multilingual\Reflection;

class MultilingualEntityReflectionClass extends \ReflectionClass
{
    public function getProperty($name)
    {
        return new MultilingualEntityPropertyReflection($this->name, $name);
    }
}