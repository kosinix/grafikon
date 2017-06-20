<?php
/**
 * Interface for image.
 */
interface Grafikon_ImageInterface {

    /**
     * Output a binary raw dump of an image in a specified format.
     *
     * @param string|Grafikon_ImageType $type Image format of the dump. See Grafikon_ImageType for supported formats.
     */
    public function blob( $type = 'PNG' );

    /**
     * Create a blank image.
     *
     * @param int $width Width of image in pixels.
     * @param int $height Height of image in pixels.
     *
     * @return Grafikon_ImageInterface Instance of image.
     */
    public static function createBlank($width = 1, $height = 1);

    /**
     * Create Image from core.
     *
     * @param resource|\Imagick $core GD resource for GD editor or Imagick instance for Imagick editor
     *
     * @return Grafikon_ImageInterface Instance of image.
     */
    public static function createFromCore($core);

    /**
     * Create Image from image file.
     *
     * @param string $imageFile Path to image file.
     *
     * @return Grafikon_ImageInterface Instance of image.
     */
    public static function createFromFile($imageFile);

    /**
     * Get histogram from an entire image or its sub-region.
     */
    public function histogram();

    /**
     * Get Image core.
     *
     * @return resource|\Imagick GD resource or Imagick instance
     */
    public function getCore();

    /**
     * @return int Height in pixels.
     */
    public function getHeight();

    /**
     * @return string File path to image if Image was created from an image file.
     */
    public function getImageFile();

    /**
     * @return string Type of image. See Grafikon_ImageType.
     */
    public function getType();

    /**
     * @return int Width in pixels.
     */
    public function getWidth();

    /**
     * Returns animated flag.
     *
     * @return bool True if animated GIF or false otherwise.
     */
    public function isAnimated();

}