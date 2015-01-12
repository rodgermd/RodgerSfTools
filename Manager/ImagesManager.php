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
use Vich\UploaderBundle\Mapping\PropertyMappingFactory;
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
    /** @var UploaderHelper */
    protected $uploader;
    /** @var PropertyMappingFactory */
    protected $mappingFactory;
    /** @var ImagineHelper */
    protected $imagine;
    /** @var EntityManager */
    protected $em;

    /**
     * Object constructor
     *
     * @param UploaderHelper         $uploader
     * @param PropertyMappingFactory $mappingFactory
     * @param ImagineHelper          $imagine
     * @param EntityManager          $em
     */
    public function __construct(UploaderHelper $uploader, PropertyMappingFactory $mappingFactory, ImagineHelper $imagine, EntityManager $em)
    {
        $this->uploader       = $uploader;
        $this->mappingFactory = $mappingFactory;
        $this->imagine        = $imagine;
        $this->em             = $em;

    }

    /**
     * Gets image url
     *
     * @param mixed  $object
     * @param string $filter
     * @param string $property
     *
     * @return string|bool
     */
    public function getImageUrl($object, $filter, $property)
    {
        if (!$this->is_uploaded($object, $property)) {
            return null;
        }

        $originalFilename = $this->uploader->asset($object, $property);

        return $this->imagine->filter($originalFilename, $filter);
    }

    /**
     * Checks if file is uploaded
     *
     * @param mixed  $object
     * @param string $field
     *
     * @return bool|string
     */
    public function is_uploaded($object, $field)
    {
        if ($object === null) {
            return false;
        }

        try {
            $this->em->initializeObject($object);

            return $this->uploader->asset($object, $field);
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }
} 