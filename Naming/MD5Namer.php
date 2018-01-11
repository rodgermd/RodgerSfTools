<?php

namespace Rodgermd\SfToolsBundle\Naming;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

/**
 * UniqidNamer.
 *
 * @author Emmanuel Vella <vella.emmanuel@gmail.com>
 */
class MD5Namer implements NamerInterface
{
    /**
     * {@inheritdoc}
     */
    public function name($object, PropertyMapping $mapping): string
    {
        /** @var UploadedFile $file */
        $file = $mapping->getFile($object);

        if (is_null($file)) {
            return false;
        }
        $extension = $file->guessExtension();
        if ($extension == 'jpeg') {
            $extension = 'jpg';
        }

        return sprintf('%s.%s', md5(uniqid()), $extension);
    }
}
