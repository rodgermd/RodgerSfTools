<?php

namespace Rodgermd\SfToolsBundle\Twig;

use \Twig_Extension;
use \Twig_SimpleFilter;
use \Twig_SimpleFunction;
use Symfony\Component\DependencyInjection\Container;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Liip\ImagineBundle\Templating\Helper\ImagineHelper;
use \InvalidArgumentException;

class ImagesExtension extends Twig_Extension
{
    protected $uploader_helper;
    protected $thumbnails_helper;

    /**
     * Object constructor
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        /** @var UploaderHelper $uploader_helper */
        $uploader_helper = $container->get('vich_uploader.templating.helper.uploader_helper');
        /** @var ImagineHelper $thumbnails_helper */
        $thumbnails_helper = $container->get('liip_imagine.templating.helper');

        $this->uploader_helper   = $uploader_helper;
        $this->thumbnails_helper = $thumbnails_helper;
    }

    /**
     * Defines filters
     * @return array
     */
    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('uploaded_image', array($this, 'uploaded_image'), array('is_safe' => array('html'))),
            new Twig_SimpleFilter('uploaded_image_source', array($this, 'uploaded_image_source'), array('is_safe' => array('html'))),
            new Twig_SimpleFilter('is_uploaded', array($this, 'is_uploaded')),
        );
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
            return $this->uploader_helper->asset($object, $property);
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }

    /**
     * Renders uploaded image
     *
     * @param mixed  $object
     * @param string $filter
     * @param string $property
     * @param array  $attributes
     *
     * @return string
     */
    public function uploaded_image($object, $filter, $property = 'file', $attributes = array())
    {
        if (!$this->is_uploaded($object, $property)) {
            return false;
        }

        return $this->image_tag($this->uploaded_image_source($object, $filter, $property), $attributes);
    }

    /**
     * Gets uploaded image source uri
     *
     * @param mixed  $object
     * @param string $filter
     * @param string $property
     *
     * @return bool|string
     */
    public function uploaded_image_source($object, $filter, $property = 'file')
    {
        if (!$this->is_uploaded($object, $property)) {
            return false;
        }
        $original_filename = $this->uploader_helper->asset($object, $property);

        return $this->thumbnails_helper->filter($original_filename, $filter);
    }

    /**
     * Renders image tag
     *
     * @param string $src
     * @param array  $params
     *
     * @return string
     */
    protected function image_tag($src, $params = array())
    {
        $default_params = array('alt' => '');
        $params         = array_merge($default_params, $params);
        $params['src']  = $src;
        $result         = array();
        foreach ($params as $key => $value) {
            $result[] = strtr('%key%="%value%"', array('%key%' => $key, '%value%' => $value));
        }

        return strtr("<img %params%/>", array('%params%' => implode(" ", $result)));
    }

    /**
     * @parent
     * @return string
     */
    public function getName()
    {
        return 'rodgermd.images_extension';
    }
}
