<?php
/**
 * Created by PhpStorm.
 * User: rodger
 * Date: 06.12.14
 * Time: 13:14.
 */

namespace Rodgermd\SfToolsBundle\Naming;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

/**
 * Class DirectoryLevelsNamer.
 */
class DirectoryLevelsNamer implements DirectoryNamerInterface
{
    /** @var int */
    protected $levels = 3;

    /** @var int */
    protected $length = 2;

    /**
     * Sets nested directory name length
     * ohgheiXa9a.jpg will be placed to ohg/hei/Xa9/ohgheiXa9a.jpg when length is 3.
     *
     * @param int $length
     *
     * @return $this
     */
    public function setLength($length): self
    {
        $this->length = (int) $length;

        return $this;
    }

    /**
     * Sets deep levels
     * ohgheiXa9a.jpg will be placed to ohg/hei/ohgheiXa9a.jpg when levels is 2.
     *
     * @param int $levels
     *
     * @return $this
     */
    public function setLevels($levels): self
    {
        $this->levels = (int) $levels;

        return $this;
    }

    /**
     * Creates a directory name for the file being uploaded.
     *
     * @param object          $object  The object the upload is attached to.
     * @param PropertyMapping $mapping The mapping to use to manipulate the given object.
     *
     * @return string The directory name.
     */
    public function directoryName($object, PropertyMapping $mapping): string
    {
        return $this->getDirectoryNameFromFilename($mapping->getFileName($object));
    }

    /**
     * Gets directory name from string filename.
     *
     * @param string $name
     *
     * @return string
     */
    public function getDirectoryNameFromFilename($name): string
    {
        $parts = array_slice(str_split($name, $this->length), 0, $this->levels);

        return implode(DIRECTORY_SEPARATOR, $parts);
    }
}
