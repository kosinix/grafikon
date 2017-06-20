<?php
/**
 * Class ImageType. Represent the different image types for GD and Imagick consistently.
 *
 * @package Grafikon
 */
class Grafikon_ImageType {

    const UNKNOWN = '';

    const GIF = 'GIF';

    const JPEG = 'JPEG';

    const PNG = 'PNG';

    const WBMP = 'WBMP';

    /**
     * Get image type base on file extension.
     *
     * @param string $fileName File name.
     *
     * @return Grafikon_ImageType string Type of image.
     */
    public static function fromFileName($fileName){
        
        $ext = strtolower((string)pathinfo($fileName, PATHINFO_EXTENSION));

        if ('jpg' === $ext or 'jpeg' === $ext) {
            return Grafikon_ImageType::JPEG;
        } else if ('gif' === $ext) {
            return Grafikon_ImageType::GIF;
        } else if ('png' === $ext) {
            return Grafikon_ImageType::PNG;
        } else if ('wbm' === $ext or 'wbmp' === $ext) {
            return Grafikon_ImageType::WBMP;
        } else {
            return Grafikon_ImageType::UNKNOWN;
        }
    }
}