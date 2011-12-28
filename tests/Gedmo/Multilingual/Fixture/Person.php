<?php

namespace Multilingual\Fixture;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @Gedmo\Multilingual
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=128)
     */
    public $name;

    /**
     * @ORM\Column(name="desc", type="string", length=128)
     */
    public $description;

    private $translations = array();

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }


    // Multilingual-specific

    public function setTranslation($field, $locale, $value)
    {
        if (!isset($this->translations[$field])) {
            $this->translations[$field] = array(
                $locale => $value
            );
        }
        else {
            $this->translations[$field][$locale] = $value;
        }

    }

    public function getTranslation($field, $locale)
    {
        if (!isset($this->translations[$field])) {
            // fallback
            return $this->{$field};
        }
        else {
            if (!isset($this->translations[$field][$locale])) {
                // fallback
                return $this->{$field};
            }
            else {
                return $this->translations[$field][$locale];
            }
        }
    }
}