<?php
require_once dirname(__FILE__).'/bootstrap.php';

class Grafikon_ImagickTest extends Grafikon_Test{

    function testCreateEditor() {
        $editor = new Grafikon_ImagickEditor();
        $this->assertTrue($editor instanceof Grafikon_ImagickEditor);
    }

    function testCreateEditorStatic(){
        $exception = false;
        try {
            Grafikon::setEditorList(array('Imagick')); // Use Imagick only

            $editor = Grafikon::createEditor();

        } catch (Exception $e){
            $exception = true;
        }
        $this->assertFalse($exception);
    }

    function testOpenFail() {
        $exception = false;
        try {
            $input = 'unreachable.jpg'; // Non existent file
            Grafikon::open($input);
        } catch (Exception $e){
            $exception = true;
        }
        $this->assertTrue($exception);
    }

    function testCompare(){
        $input1 = Grafikon_ImagickImage::createFromFile($this->lib.'tests/images/lena.png');
        $input2 = Grafikon_ImagickImage::createFromFile($this->lib.'tests/images/lena-gray.png');
        $editor = Grafikon::getAvailableEditor(array("Imagick"));
        $ham = $editor->compare($input1, $input2);

        $this->assertLessThan(10, $ham); // hamming distance: 0 is equal, 1-10 is similar, 11+ is different image
    }

    function testSave(){
        $input = $this->lib.'tests/images/sample.png';
        $output1 = $this->lib.'tests/tmp/' . __FUNCTION__ . '1.jpg';
        $output2 = $this->lib.'tests/tmp/' . __FUNCTION__ . '2.jpg';
        $output3 = $this->lib.'tests/tmp/' . __FUNCTION__ . '3.png';

        $editor = Grafikon::getAvailableEditor(array("Imagick"));

        $image = Grafikon::open($input);
        $editor->save($image, $output1, 'jpg', 100);
        $this->assertEquals(0, $editor->compare($input, $output1));

        $editor->save($image, $output2, 'jpg', 0);
        $this->assertGreaterThan(0, $editor->compare($input, $output2)); // Not exactly similar due to compression

        $editor->save($image, $output3, 'png', null);
        $this->assertEquals(0, $editor->compare($input, $output3));

    }

    // Animated gif
    function testResizeFitEnlarge(){
        $image = Grafikon_ImagickImage::createFromFile($this->lib.'tests/images/sample.gif');
        $output = $this->lib.'tests/tmp/testResizeFitEnlarge.gif';
        $correct = $this->lib.'tests/assert-imagick/testResizeFitEnlarge.gif';
        $editor = Grafikon::getAvailableEditor(array("Imagick"));
        $editor->resizeFit($image, $image->getWidth() + 100, $image->getHeight() + 100);
        $editor->save($image, $output);

        $this->assertLessThanOrEqual(5, $editor->compare($output, $correct));
    }
}

Grafikon_Test::run($lib, 'Grafikon_ImagickTest');
