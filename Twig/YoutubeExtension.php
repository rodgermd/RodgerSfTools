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

class YoutubeExtension extends Twig_Extension
{
    const VIDEO_URL   = 'http://www.youtube.com/embed/%code%';
    const IFRAME_CODE = '<iframe frameborder="0" scrolling="no" src="%url%"></iframe>';

    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('youtube_preview', array($this, 'youtube_image_preview'), array('is_safe' => array('html'))),
            new Twig_SimpleFilter('youtube_embed', array($this, 'youtube_embed'), array('is_safe' => array('html'))),
            new Twig_SimpleFilter('youtube_embed_url', array($this, 'youtube_embed_url'), array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders youtube video preview image
     *
     * @param     $url
     * @param int $thumbnail
     *
     * @return bool|string
     */
    public function youtube_image_preview($url, $thumbnail = 0)
    {
        $code = $this->youtube_id($url);

        return $code ? 'http://img.youtube.com/vi/' . $code . '/' . $thumbnail . '.jpg' : false;
    }

    /**
     * Renders youtube embeded video
     *
     * @param $url
     *
     * @return bool|string
     */
    public function youtube_embed($url)
    {
        $url = $this->youtube_embed_url($url);
        if (!$url) {
            return false;
        }

        return strtr(self::IFRAME_CODE, array('%url%' => $url));
    }

    /**
     * Gets embed url
     *
     * @param $url
     *
     * @return bool|string
     */
    public function youtube_embed_url($url)
    {
        $code = $this->youtube_id($url);

        return $code ? strtr(self::VIDEO_URL, array('%code%' => $code)) : false;
    }

    /**
     * Parses youtube identificator from url
     *
     * @param $url
     *
     * @return bool
     */
    protected function youtube_id($url)
    {
        preg_match("/\/watch\?v=(?P<code>[\w\d\-]+)/", $url, $matches);

        return @$matches['code'] ? : false;
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