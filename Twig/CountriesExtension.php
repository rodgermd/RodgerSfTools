<?php
/**
 * Created by PhpStorm.
 * User: rodger
 * Date: 11.12.13
 * Time: 10:48.
 */

namespace Rodgermd\SfToolsBundle\Twig;

use Symfony\Component\Intl\Intl;
use Twig_Extension;
use Twig_SimpleFilter;

/**
 * Class CountriesExtension.
 */
class CountriesExtension extends Twig_Extension
{
    protected $countries;

    /**
     * Gets filters.
     *
     * @return array
     */
    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('country', array($this, 'country')),
        );
    }

    /**
     * Gets country name by code.
     *
     * @param string $code
     * @param string $culture
     *
     * @return string
     */
    public function country($code, $culture = null)
    {
        if (!$code) {
            return;
        }
        if (!$this->countries) {
            $this->countries = Intl::getRegionBundle()->getCountryNames($culture);
        }

        return $this->countries[strtoupper($code)];
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'countries';
    }
}
