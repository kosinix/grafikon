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
        $input1 = Grafikon_ImagickImage::createFromFile($this->lib.'tests/in/lena.png');
        $input2 = Grafikon_ImagickImage::createFromFile($this->lib.'tests/in/lena-gray.png');
        $editor = Grafikon::createEditor(array("Imagick"));
        $ham = $editor->compare($input1, $input2);

        $this->assertLessThan(10, $ham); // hamming distance: 0 is equal, 1-10 is similar, 11+ is different image
    }

    function testSave(){
        $input = $this->lib.'tests/in/sample.png';
        $output1 = $this->lib.'tests/out/' . __FUNCTION__ . '1.jpg';
        $output2 = $this->lib.'tests/out/' . __FUNCTION__ . '2.jpg';
        $output3 = $this->lib.'tests/out/' . __FUNCTION__ . '3.png';

        $editor = Grafikon::createEditor(array("Imagick"));

        $image = Grafikon::open($input);
        $editor->save($image, $output1, 'jpg', 100);
        $this->assertEquals(0, $editor->compare($input, $output1));

        $editor->save($image, $output2, 'jpg', 0);
        $this->assertGreaterThan(0, $editor->compare($input, $output2)); // Not exactly similar due to compression

        $editor->save($image, $output3, 'png', null);
        $this->assertEquals(0, $editor->compare($input, $output3));

    }

    function testAddTextOnBlankImage() {

        $output = $this->lib . 'tests/out/' . __FUNCTION__ . '.jpg';
        $correct = $this->lib . 'tests/assert-imagick/' . __FUNCTION__ . '.jpg';

        $blank = Grafikon_ImagickImage::createBlank( 400, 100 );
        $editor = Grafikon::createEditor(array("Imagick"));
        $editor->fill( $blank, new Grafikon_Color( '#ffffff' ) );
        $editor->text( $blank, 'Lorem ipsum - Liberation Sans');
        $editor->save( $blank, $output);

        $this->assertLessThanOrEqual(5, $editor->compare($output, $correct)); // Account for windows and linux generating different text sizes given the same font size.
    }


    function testAddTextOnJpeg() {

        $input = $this->lib . 'tests/in/sample.jpg';
        $output = $this->lib . 'tests/out/' . __FUNCTION__ . '.jpg';
        $correct = $this->lib . 'tests/assert-imagick/' . __FUNCTION__ . '.jpg';

        $image = Grafikon_ImagickImage::createFromFile($input);
        $editor = Grafikon::createEditor(array("Imagick"));
        $editor->resizeFit($image, 300, 300);
        $editor->text($image, 'Lorem ipsum - Liberation Sans');
        $editor->save($image, $output);

        $this->assertLessThanOrEqual(5, $editor->compare($output, $correct)); // Account for windows and linux generating different text sizes given the same font size.
    }

    // Animated gif
    function testResizeFitEnlarge(){
        $image = Grafikon_ImagickImage::createFromFile($this->lib.'tests/in/sample.gif');
        $output = $this->lib.'tests/out/testResizeFitEnlarge.gif';
        $correct = $this->lib.'tests/assert-imagick/testResizeFitEnlarge.gif';
        $editor = Grafikon::createEditor(array("Imagick"));
        $editor->resizeFit($image, $image->getWidth() + 100, $image->getHeight() + 100);
        $editor->save($image, $output);

        $this->assertLessThanOrEqual(5, $editor->compare($output, $correct));
    }

    public function testCrop(){
        $input   = $this->lib . 'tests/in/crop-test.jpg';

        $output1  = $this->lib . 'tests/out/' . __FUNCTION__ . '1.jpg';
        $correct1 = $this->lib . 'tests/assert-imagick/' . __FUNCTION__ . '1.jpg';

        $output2  = $this->lib . 'tests/out/' . __FUNCTION__ . '2.jpg';
        $correct2 = $this->lib . 'tests/assert-imagick/' . __FUNCTION__ . '2.jpg';

        $output3  = $this->lib . 'tests/out/' . __FUNCTION__ . '3.jpg';
        $correct3 = $this->lib . 'tests/assert-imagick/' . __FUNCTION__ . '3.jpg';

        $output4  = $this->lib . 'tests/out/' . __FUNCTION__ . '4.jpg';
        $correct4 = $this->lib . 'tests/assert-imagick/' . __FUNCTION__ . '4.jpg';

        $output5  = $this->lib . 'tests/out/' . __FUNCTION__ . '5.jpg';
        $correct5 = $this->lib . 'tests/assert-imagick/' . __FUNCTION__ . '5.jpg';

        $output6  = $this->lib . 'tests/out/' . __FUNCTION__ . '6.jpg';
        $correct6 = $this->lib . 'tests/assert-imagick/' . __FUNCTION__ . '6.jpg';

        $output7  = $this->lib . 'tests/out/' . __FUNCTION__ . '7.jpg';
        $correct7 = $this->lib . 'tests/assert-imagick/' . __FUNCTION__ . '7.jpg';

        $output8  = $this->lib . 'tests/out/' . __FUNCTION__ . '8.jpg';
        $correct8 = $this->lib . 'tests/assert-imagick/' . __FUNCTION__ . '8.jpg';

        $output9  = $this->lib . 'tests/out/' . __FUNCTION__ . '9.jpg';
        $correct9 = $this->lib . 'tests/assert-imagick/' . __FUNCTION__ . '9.jpg';

        $editor = Grafikon::createEditor(array("Imagick"));
        $image = Grafikon_ImagickImage::createFromFile( $input );
        $editor->crop( $image, 260, 150, 'top-left' );
        $editor->save( $image, $output1);

        $this->assertLessThanOrEqual(5, $editor->compare($output1, $correct1));

        $image = Grafikon_ImagickImage::createFromFile( $input );
        $editor->crop( $image, 260, 150, 'top-center' );
        $editor->save( $image, $output2);
        $this->assertLessThanOrEqual(5, $editor->compare($output2, $correct2));

        $image = Grafikon_ImagickImage::createFromFile( $input );
        $editor->crop( $image, 260, 150, 'top-right' );
        $editor->save( $image, $output3);
        $this->assertLessThanOrEqual(5, $editor->compare($output3, $correct3));

        //
        $image = Grafikon_ImagickImage::createFromFile( $input );
        $editor->crop( $image, 260, 150, 'center-left' );
        $editor->save( $image, $output4);
        $this->assertLessThanOrEqual(5, $editor->compare($output4, $correct4));

        $image = Grafikon_ImagickImage::createFromFile( $input );
        $editor->crop( $image, 260, 150, 'center' );
        $editor->save( $image, $output5);
        $this->assertLessThanOrEqual(5, $editor->compare($output5, $correct5));

        $image = Grafikon_ImagickImage::createFromFile( $input );
        $editor->crop( $image, 260, 150, 'center-right' );
        $editor->save( $image, $output6);
        $this->assertLessThanOrEqual(5, $editor->compare($output6, $correct6));
        //
        $image = Grafikon_ImagickImage::createFromFile( $input );
        $editor->crop( $image, 260, 150, 'bottom-left' );
        $editor->save( $image, $output7);
        $this->assertLessThanOrEqual(5, $editor->compare($output7, $correct7));

        $image = Grafikon_ImagickImage::createFromFile( $input );
        $editor->crop( $image, 260, 150, 'bottom-center' );
        $editor->save( $image, $output8);
        $this->assertLessThanOrEqual(5, $editor->compare($output8, $correct8));

        $image = Grafikon_ImagickImage::createFromFile( $input );
        $editor->crop( $image, 260, 150, 'bottom-right' );
        $editor->save( $image, $output9);
        $this->assertLessThanOrEqual(5, $editor->compare($output9, $correct9));
    }

    public function testSmartCrop(){
        $input = $this->lib . 'tests/in/lena.png';
        $output = $this->lib . 'tests/out/' . __FUNCTION__ . '1.jpg';
        $correct = $this->lib . 'tests/assert-imagick/' . __FUNCTION__ . '1.jpg';

        $editor = Grafikon::createEditor(array("Imagick"));
        $image = Grafikon_ImagickImage::createFromFile( $input );
        $editor->crop( $image, 250, 250, 'smart' );
        $editor->save( $image, $output );

        $this->assertLessThanOrEqual(5, $editor->compare($correct, $output)); // Account for minor variations due to different GD versions (GD image that gen. asserts is different on the testing site)

        $input = $this->lib . 'tests/in/tower.jpg';
        $output = $this->lib . 'tests/out/' . __FUNCTION__ . '2.jpg';
        $correct = $this->lib . 'tests/assert-imagick/' . __FUNCTION__ . '2.jpg';

        $image = Grafikon_ImagickImage::createFromFile( $input );
        $editor->crop( $image, 260, 400, 'smart' );
        $editor->save( $image, $output );

        $this->assertLessThanOrEqual(5, $editor->compare($correct, $output)); // Account for minor variations due to different GD versions (GD image that gen. asserts is different on the testing site)

        $input = $this->lib . 'tests/in/portal-companion-cube.jpg';
        $output = $this->lib . 'tests/out/' . __FUNCTION__ . '3.jpg';
        $correct = $this->lib . 'tests/assert-imagick/' . __FUNCTION__ . '3.jpg';

        $image = Grafikon_ImagickImage::createFromFile( $input );
        $editor->crop( $image, 200, 200, 'smart' );
        $editor->save( $image, $output );

        $this->assertLessThanOrEqual(5, $editor->compare($correct, $output)); // Account for minor variations due to different GD versions (GD image that gen. asserts is different on the testing site)

        $input = $this->lib . 'tests/in/sample.jpg';
        $output = $this->lib . 'tests/out/' . __FUNCTION__ . '4.jpg';
        $correct = $this->lib . 'tests/assert-imagick/' . __FUNCTION__ . '4.jpg';

        $image = Grafikon_ImagickImage::createFromFile( $input );
        $editor->crop( $image, 200, 200, 'smart' );
        $editor->save( $image, $output );

        $this->assertLessThanOrEqual(5, $editor->compare($correct, $output)); // Account for minor variations due to different GD versions (GD image that gen. asserts is different on the testing site)

        $input = $this->lib . 'tests/in/sample.png';
        $output = $this->lib . 'tests/out/' . __FUNCTION__ . '5.jpg';
        $correct = $this->lib . 'tests/assert-imagick/' . __FUNCTION__ . '5.jpg';

        $image = Grafikon_ImagickImage::createFromFile( $input );
        $editor->crop( $image, 200, 200, 'smart' );
        $editor->save( $image, $output );

        $this->assertLessThanOrEqual(5, $editor->compare($correct, $output)); // Account for minor variations due to different GD versions (GD image that gen. asserts is different on the testing site)
    }
}

$reflectedClass = new ReflectionClass('Grafikon_ImagickTest');
$instance = $reflectedClass->newInstance($lib);

echo "Starting test \n";
echo "PHP version: ".PHP_VERSION." \n\n";

echo $reflectedClass->name."\n";
echo "Deleting out dir...\n";
foreach($reflectedClass->getMethods() as $method){
    
    if(substr($method->name, 0, 4) === 'test'){
        echo " \n {$method->name}... ";
        $method->invoke($instance);
    }
}

echo "\n\n";
if($instance->fail === 0 ){
    echo "Test result: OK\n";
    exit(0);
} else {
    echo "Test result: FAILED\n";
    exit(1);
}
