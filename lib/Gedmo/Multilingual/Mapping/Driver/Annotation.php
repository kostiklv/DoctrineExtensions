<?php

namespace Gedmo\Multilingual\Mapping\Driver;

use Gedmo\Mapping\Driver\AnnotationDriverInterface,
    Doctrine\Common\Persistence\Mapping\ClassMetadata,
    Gedmo\Exception\InvalidMappingException;

/**
 * This is an annotation mapping driver for Multilingual
 * behavioral extension. Used for extraction of extended
 * metadata from Annotations specifically for Multilingual
 * extension.
 *
 * @author Konstantin Tjuterev <kostik.lv@gmail.com>
 * @package Gedmo.Multilingual.Mapping.Driver
 * @subpackage Annotation
 * @link http://www.gediminasm.org
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)* @author Boussekeyt Jules <jules.boussekeyt@gmail.com>
 */
class Annotation implements AnnotationDriverInterface
{
    /**
     * Annotation to define that this object has Multilingual fields
     */
    const MULTILINGUAL = 'Gedmo\\Mapping\\Annotation\\Multilingual';

    /**
     * Annotation reader instance
     *
     * @var object
     */
    private $reader;

    /**
     * original driver if it is available
     */
    protected $_originalDriver = null;
    /**
     * {@inheritDoc}
     */
    public function setAnnotationReader($reader)
    {
        $this->reader = $reader;
    }

    /**
     * {@inheritDoc}
     */
    public function readExtendedMetadata(ClassMetadata $meta, array &$config)
    {
        $class = $meta->getReflectionClass();
        // class annotations
        if ($annot = $this->reader->getClassAnnotation($class, self::MULTILINGUAL)) {
            $config['multilingual'] = true;
        }
    }

    /**
     * Passes in the mapping read by original driver
     *
     * @param $driver
     * @return void
     */
    public function setOriginalDriver($driver)
    {
        $this->_originalDriver = $driver;
    }
}