<?php
/**
 * Hold and computes position of objects added to canvas.
 *
 * @package Grafikon
 */
class Grafikon_Position {

	/**
     * Top left of the canvas.
     */
    public $TOP_LEFT = 'top-left';
	/**
     * Top center of the canvas.
     */
    public $TOP_CENTER = 'top-center';
	/**
     * Top right of the canvas.
     */
    public $TOP_RIGHT = 'top-right';
	/**
     * Center left of the canvas.
     */
    public $CENTER_LEFT = 'center-left';
	/**
     * Center of the canvas.
     */
    public $CENTER = 'center';
	/**
     * Center right of the canvas.
     */
    public $CENTER_RIGHT = 'center-right';
	/**
     * Center left of the canvas.
     */
    public $BOTTOM_LEFT = 'bottom-left';
	/**
     * Bottom center of the canvas.
     */
    public $BOTTOM_CENTER = 'bottom-center';
	/**
     * Bottom right of the canvas.
     */
    public $BOTTOM_RIGHT = 'bottom-right';

	/**
     * @var string Holds position in human-readable text.
     */
    private $position;
	/**
     * @var int Number of pixels to the left of the origin
     */
    private $offsetX;
	/**
     * @var int Number of pixels to the bottom of the origin.
     */
    private $offsetY;

	/**
     * Position constructor.
     *
     * @param string $position Defaults to center.
     * @param int $offsetX Defaults to 0.
     * @param int $offsetY Defaults to 0.
     */
    public function __construct($position='center', $offsetX=0, $offsetY=0) {
        $this->position = $position;
        $this->offsetX = $offsetX;
        $this->offsetY = $offsetY;
    }

	/**
     * Translate the textual position + offsets into x,y values.
     *
     * @param int $canvasWidth Width of canvas.
     * @param int $canvasHeight Height of canvas.
     * @param int $imageWidth Width of image/object added.
     * @param int $imageHeight Height of image/object added.
     *
     * @return array Array of X and Y coordinates: array($x, $y).
     * @throws \Exception When invalid position.
     */
    public function getXY($canvasWidth, $canvasHeight, $imageWidth, $imageHeight){
        if ( $this->TOP_LEFT === $this->position) {
            $x = 0;
            $y = 0;
        } else if ( $this->TOP_CENTER === $this->position) {
            $x = (int)round(($canvasWidth / 2) - ($imageWidth / 2));
            $y = 0;
        } else if ( $this->TOP_RIGHT === $this->position) {
            $x = $canvasWidth - $imageWidth;
            $y = 0;
        } else if ( $this->CENTER_LEFT === $this->position) {
            $x = 0;
            $y = (int)round(($canvasHeight / 2) - ($imageHeight / 2));
        } else if ( $this->CENTER_RIGHT === $this->position) {
            $x = $canvasWidth - $imageWidth;
            $y = (int)round(($canvasHeight / 2) - ($imageHeight / 2));
        } else if ( $this->BOTTOM_LEFT === $this->position) {
            $x = 0;
            $y = $canvasHeight - $imageHeight;
        } else if ( $this->BOTTOM_CENTER === $this->position) {
            $x = (int)round(($canvasWidth / 2) - ($imageWidth / 2));
            $y = $canvasHeight - $imageHeight;
        } else if ( $this->BOTTOM_RIGHT === $this->position) {
            $x = $canvasWidth - $imageWidth;
            $y = $canvasHeight - $imageHeight;
        } else if ( $this->CENTER === $this->position) {
            $x = (int)round(($canvasWidth / 2) - ($imageWidth / 2));
            $y = (int)round(($canvasHeight / 2) - ($imageHeight / 2));
        } else {
            throw new Exception( sprintf( 'Invalid position "%s".', $this->position ) );
        }

        return array(
            $x + $this->offsetX,
            $y + $this->offsetY
        );
    }

    /**
     * @return string
     */
    public function getText() {
        return $this->position;
    }

    /**
     * @return int
     */
    public function getOffsetY() {
        return $this->offsetY;
    }

    /**
     * @return int
     */
    public function getOffsetX() {
        return $this->offsetX;
    }


}