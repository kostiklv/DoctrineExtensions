<?php

namespace Gedmo\Multilingual\Reflection;

/**
 * Created by JetBrains PhpStorm.
 * User: Kostja
 * Date: 12/28/11
 * Time: 10:56 PM
 * To change this template use File | Settings | File Templates.
 */
class MultilingualEntityPropertyReflection
{
    public $name = null;
    protected $locale = null;
    protected $translatable = false;
    protected $realReflection = null;

    public function __construct($class, $name)
    {
        $this->class = $class;

        if (preg_match('/([a-zA-Z0-9_]+)_([a-z]{2})$/', $name, $parts)) {
            $this->name = $parts[1];
            $this->locale = $parts[2];
            $this->translatable = true;
        }
        else {
            $this->realReflection = new \ReflectionProperty($class, $name);
            $this->name = $name;
        }
    }

    public function setAccessible($flag)
    {
        if (!$this->translatable) {
            $this->realReflection->setAccessible($flag);
        }
    }

    public function setValue($entity = null, $value = null)
    {
        if ($this->translatable) {
            $entity->setTranslation($this->name, $this->locale, $value);
        }
        else {
            $this->realReflection->setValue($entity, $value);
        }
    }

    public function getValue($entity = null)
    {
        if ($this->translatable) {
            return $entity->getTranslation($this->name, $this->locale);
        }
        return $this->realReflection->getValue($entity);
    }
}
