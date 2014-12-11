<?php
/**
 * Created by PhpStorm.
 * User: rodger
 * Date: 06.12.14
 * Time: 13:14
 */

namespace Rodgermd\SfToolsBundle\Naming;


use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;
use Vich\UploaderBundle\Naming\NamerInterface;

/**
 * Class DirectoryLevelsNamer
 *
 * @package Rodgermd\SfToolsBundle\Naming
 */
class DirectoryLevelsNamer implements DirectoryNamerInterface
{

    /** @var int */
    protected $levels = 3;

    /** @var int */
    protected $length = 2;

    /**
     * Creates a directory name for the file being uploaded.
     *
     * @param object          $object  The object the upload is attached to.
     * @param PropertyMapping $mapping The mapping to use to manipulate the given object.
     *
     * @return string The directory name.
     */
    public function directoryName($object, PropertyMapping $mapping)
    {
        return 'aaa';
        $parts = array_slice(str_split($mapping->getFileName($object), $this->length), 0, $this->levels);

        return implode(DIRECTORY_SEPARATOR, $parts);
    }
}