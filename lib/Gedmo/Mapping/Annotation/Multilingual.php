<?php

namespace Gedmo\Mapping\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * Multilingual annotation for Multilingual behavioral extension
 *
 * @Annotation
 * @Target("CLASS")
 *
 * @author Konstantin Tjuterev <kostik.lv@gmail.com>
 * @package Gedmo.Mapping.Annotation
 * @subpackage Multilingual
 * @link http://www.gediminasm.org
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
final class Multilingual extends Annotation
{
    /** @var string */
    public $logEntryClass;
}

