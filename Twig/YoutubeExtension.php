<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rodger
 * Date: 8/11/13
 * Time: 1:20 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Rodgermd\SfToolsBundle\Twig;

use \Twig_Extension;
use \Twig_SimpleFilter;

class YoutubeExtension extends Twig_Extension {

  public function getFilters()
  {
    return array(
      new Twig_SimpleFilter('youtube_preview', array($this, 'youtube_image_preview'), array('is_safe' => array('html'))),
    );
  }

  public function youtube_image_preview($url, $thumbnail = 0) {
    preg_match("/\/watch\?v=(?P<code>[\w\d]+)/", $url, $matches);

    if (@$matches['code']) {
      return 'http://img.youtube.com/vi/' . $matches['code'] . '/' . $thumbnail . '.jpg';
    }
    return false;
  }

  /**
   * Returns the name of the extension.
   *
   * @return string The extension name
   */
  public function getName()
  {
    return 'youtube';
  }
}