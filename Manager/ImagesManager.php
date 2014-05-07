<?php
/**
 * Created by PhpStorm.
 * User: rodger
 * Date: 13.02.14
 * Time: 15:40
 */

namespace Rodgermd\SfToolsBundle\Manager;


use Doctrine\ORM\EntityManager;
use Liip\ImagineBundle\Templating\Helper\ImagineHelper;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use \InvalidArgumentException;

/**
 * Class ImagesManager
 * Manages uploaded images
 *
 * @package Rodgermd\SfToolsBundle\Manager
 */
class ImagesManager
{
    /** @var \Vich\UploaderBundle\Templating\Helper\UploaderHelper */
    protected $uploader;
    /** @var \Liip\ImagineBundle\Templating\Helper\ImagineHelper */
    protected $imagine;
    protected $em;

    /**
     * Object constructor
     *
     * @param UploaderHelper $uploader
     * @param ImagineHelper  $imagine
     */
    public function __construct(UploaderHelper $uploader, ImagineHelper $imagine, EntityManager $em)
    {
        $this->uploader = $uploader;
        $this->imagine  = $imagine;
        $this->em       = $em;

    }

    /**
     * Gets image url
     *
     * @param mixed  $object
     * @param string $filter
     * @param string $property
     * @param bool   $absolute
     *
     * @return bool
     */
    public function getImageUrl($object, $filter, $property, $absolute = false)
    {
        if (!$this->is_uploaded($object, $property)) {
            return false;
        }

        $original_filename = $this->uploader->asset($object, $property);

        return $this->imagine->filter($original_filename, $filter, $absolute);
    }

    /**
     * Checks if file is uploaded
     *
     * @param        $object
     * @param string $property
     *
     * @return bool|string
     */
    public function is_uploaded($object, $property = 'file')
    {
        if ($object === null) {
            return false;
        }

        try {
            $this->em->initializeObject($object);
            return $this->uploader->asset($object, $property);
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }
} 