<?php
/**
 * Created by PhpStorm.
 * User: rodger
 * Date: 24.06.14
 * Time: 16:23
 */

namespace Rodgermd\SfToolsBundle\Twig;

use \Twig_Extension;
use \Twig_SimpleFilter;

/**
 * Class StringExtension
 *
 * @package Rodgermd\SfToolsBundle\Twig
 */
class StringExtension extends Twig_Extension
{
    /**
     * Defines filters
     *
     * @return array
     */
    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('matches', array($this, 'matches')),
        );
    }

    /**
     * Checks if value matches regexp pattern
     *
     * @param $value
     * @param $pattern
     *
     * @return int
     */
    public function matches($value, $pattern)
    {
        return preg_match($pattern, $value);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'string_extension';
    }
}