<?php

namespace Rodgermd\SfToolsBundle\Twig;

use Rodgermd\SfToolsBundle\Manager\ImagesManager;
use \Twig_Extension;
use \Twig_SimpleFilter;
use Symfony\Component\DependencyInjection\Container;
use \InvalidArgumentException;

class ImagesExtension extends Twig_Extension
{
    protected $manager;

    /**
     * Object constructor
     *
     * @param \Rodgermd\SfToolsBundle\Manager\ImagesManager $manager
     */
    public function __construct(ImagesManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Defines filters
     *
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
        return $this->manager->is_uploaded($object, $property);
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
        if (!$this->manager->is_uploaded($object, $property)) {
            return false;
        }

        $absolute = false;
        if (array_key_exists('absolute', $attributes)) {
            $absolute = (bool)$attributes['absolute'];
            unset($attributes['absolute']);
        }

        return $this->image_tag($this->manager->getImageUrl($object, $filter, $property, $absolute), $attributes);
    }

    /**
     * Gets uploaded image source uri
     *
     * @param mixed  $object
     * @param string $filter
     * @param string $property
     * @param bool   $absolute
     *
     * @return bool|string
     */
    public function uploaded_image_source($object, $filter, $property = 'file', $absolute = false)
    {
        return $this->manager->getImageUrl($object, $filter, $property, $absolute);
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
