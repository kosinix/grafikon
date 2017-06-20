<?php
class Grafikon {

    /**
     * @var array $editorList List of editors to evaluate.
     */
    private static $editorList = array('Imagick', 'Gd');

    /**
     * Return path to directory containing fonts used in text operations.
     *
     * @return string
     */
    public static function fontsDir()
    {
        $ds = DIRECTORY_SEPARATOR;
        return realpath(dirname(__FILE__) . $ds . '..' ) . $ds . 'fonts';
    }
    
    /**
     * Change the editor list order of evaluation globally.
     *
     * @param array $editorList
     *
     * @throws Exception
     */
    public static function setEditorList($editorList){
        if(!is_array($editorList)){
            throw new Exception('$editorList must be an array.');
        }
        self::$editorList = $editorList;
    }

    /**
     * Detects and return the name of the first supported editor which can either be "Imagick" or "Gd".
     *
     * @param array $editorList Array of editor list names. Use this to change the order of evaluation for editors for this function call only. Default order of evaluation is Imagick then GD.
     *
     * @return string Name of available editor.
     * @throws Exception Throws exception if there are no supported editors.
     */
    public static function detectAvailableEditor($editorList = null)
    {

        if(null === $editorList){
            $editorList = self::$editorList;
        }

        /* Get first supported editor instance. Order of editorList matter. */
        foreach ($editorList as $editorName) {
            if ('Imagick' === $editorName) {
                $editorInstance = new Grafikon_ImagickEditor();
            } else {
                $editorInstance = new Grafikon_GdEditor();
            }
            /** @var EditorInterface $editorInstance */
            if (true === $editorInstance->isAvailable()) {
                return $editorName;
            }
        }

        throw new Exception('No supported editor.');
    }

    /**
     * Creates the first available editor.
     *
     * @param array $editorList Array of editor list names. Use this to change the order of evaluation for editors. Default order of evaluation is Imagick then GD.
     *
     * @return Grafikon_EditorInterface
     * @throws Exception
     */
    public static function createEditor($editorList = array('Imagick', 'Gd'))
    {
        $editorName = self::detectAvailableEditor($editorList);
        if ('Imagick' === $editorName) {
            return new Grafikon_ImagickEditor();
        } else {
            return new Grafikon_GdEditor();
        }
    }

    /**
     * Detects and return the first supported editor which can either be Imagick or Gd.
     *
     * @param array $editorList Array of editor list names. Use this to change the order of evaluation for editors for this function call only. Default order of evaluation is Imagick then GD.
     *
     * @return Grafikon_EditorInterface
     * @throws Exception Throws exception if there are no supported editors.
     */
    public static function getAvailableEditor($editorList = null)
    {

        if(null === $editorList){
            $editorList = self::$editorList;
        }

        /* Get first supported editor instance. Order of editorList matter. */
        foreach ($editorList as $editorName) {
            if ('Imagick' === $editorName) {
                $editorInstance = new Grafikon_ImagickEditor();
            } else {
                $editorInstance = new Grafikon_GdEditor();
            }
            /** @var EditorInterface $editorInstance */
            if (true === $editorInstance->isAvailable()) {
                return $editorInstance;
            }
        }

        throw new Exception('No supported editor.');
    }

    /**
     * Open an image file.
     *
     * @param string $path Full path to image file.
     *
     * @return Grafikon_Image
     */
    public static function open($path){

        $editor = self::getAvailableEditor();
        
        return $editor->open($path);

    }

    /**
     * Compare two images and returns a hamming distance. A value of 0 indicates a likely similar picture. A value between 1 and 10 is potentially a variation. A value greater than 10 is likely a different image.
     *
     * @param ImageInterface|string $image1
     * @param ImageInterface|string $image2
     *
     * @return int Hamming distance. Note: This breaks the chain if you are doing fluent api calls as it does not return an Editor.
     */
    public static function compare($image1, $image2) {
        $editor = self::getAvailableEditor();
        
        return $editor->compare($image1, $image2);
    }

    /**
     * Crop the image to the given dimension and position.
     *
     * @param Grafikon_GdImage $image
     * @param int $cropWidth Crop width in pixels.
     * @param int $cropHeight Crop Height in pixels.
     * @param string $position The crop position. Possible values top-left, top-center, top-right, center-left, center, center-right, bottom-left, bottom-center, bottom-right and smart. Defaults to center.
     * @param int $offsetX Number of pixels to add to the X position of the crop.
     * @param int $offsetY Number of pixels to add to the Y position of the crop.
     */
    public static function crop( &$image, $cropWidth, $cropHeight, $position = 'center', $offsetX = 0, $offsetY = 0) {
        $editor = self::getAvailableEditor();

        $editor->crop( $image, $cropWidth, $cropHeight, $position, $offsetX, $offsetY);
    }

    /**
     * Resize image given width, height and mode.
     *
     * @param Grafikon_Image $image
     * @param int $newWidth Width in pixels.
     * @param int $newHeight Height in pixels.
     * @param string $mode Resize mode. Possible values: "exact", "exactHeight", "exactWidth", "fill", "fit".
     */
    public static function resize(&$image, $newWidth, $newHeight, $mode = 'fit') {
        $editor = self::getAvailableEditor();

        $editor->resize($image, $newWidth, $newHeight, $mode);
    }

    /**
     * Save the image to an image format.
     *
     * @param Grafikon_Image $image
     * @param string $file File path where to save the image.
     * @param null|string $type Type of image. Can be null, "GIF", "PNG", or "JPEG".
     * @param null|string $quality Quality of image. Applies to JPEG only. Accepts number 0 - 100 where 0 is lowest and 100 is the highest quality. Or null for default.
     * @param bool|false $interlace Set to true for progressive JPEG. Applies to JPEG only.
     * @param int $permission Default permission when creating non-existing target directory.
     *
     * @return bool
     * @throws Exception
     */
    public static function save($image, $file, $type = null, $quality = null, $interlace = false, $permission = 0755){
        $editor = self::getAvailableEditor();
        return $editor->save($image, $file, $type, $quality, $interlace, $permission);
    }
}