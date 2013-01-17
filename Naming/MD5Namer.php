<?php

namespace Rodgermd\SfToolsBundle\Naming;
use Vich\UploaderBundle\Naming\NamerInterface;

/**
 * UniqidNamer
 *
 * @author Emmanuel Vella <vella.emmanuel@gmail.com>
 */
class MD5Namer implements NamerInterface
{
  /**
   * {@inheritDoc}
   */
  public function name($obj, $field)
  {
    $refObj = new \ReflectionObject($obj);

    $refProp = $refObj->getProperty($field);
    $refProp->setAccessible(true);

    $file = $refProp->getValue($obj);

    return sprintf('%s.%s', md5(uniqid()), $file->guessExtension());
  }
}
