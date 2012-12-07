<?php

namespace Rodgermd\SfToolsBundle\Twig;

use \Twig_Extension;
use \Twig_Filter_Method;
use \Twig_Function_Method;
use Symfony\Component\DependencyInjection\Container;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Liip\ImagineBundle\Templating\Helper\ImagineHelper;

class ImagesExtension extends Twig_Extension
{
  protected $uploader_helper;
  protected $thumbnails_helper;

  public function __construct(Container $container)
  {
    /** @var UploaderHelper $uploader_helper  */
    $uploader_helper = $container->get('vich_uploader.templating.helper.uploader_helper');
    /** @var ImagineHelper $thumbnails_helper  */
    $thumbnails_helper = $container->get('liip_imagine.templating.helper');

    $this->uploader_helper = $uploader_helper;
    $this->thumbnails_helper = $thumbnails_helper;
  }

  public function getFilters()
  {
    return array(
      'uploaded_image' => new Twig_Filter_Method($this, 'uploaded_image', array('is_safe' => array('html'))),
    );
  }

  /**
   * Renders uploaded image
   * @param $object
   * @param $filter
   * @param string $property
   * @return string
   */
  public function uploaded_image($object, $filter, $property = 'file')
  {
    $original_filename = $this->uploader_helper->asset($object, $property);
    return $this->image_tag($this->thumbnails_helper->filter($original_filename, $filter));
  }

  /**
   * Renders image tag
   * @param $src
   * @param array $params
   * @return string
   */
  protected function image_tag($src, $params = array())
  {
    $default_params = array('alt' => '');
    $params = array_merge($default_params, $params);
    $params['src'] = $src;
    $result = [];
    foreach($params as $key => $value) $result[] = strtr('%key%="%value%"', array('%key%' => $key, '%value%' => $value));
    return strtr("<img %params%/>", array('%params%' => $result));
  }

  public function getName()
  {
    return 'rodgermd.images_extemsion';
  }
}