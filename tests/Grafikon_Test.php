<?php
// Simple testing class for PHP 5.2
abstract class Grafikon_Test {
    public $lib = '';
    public $fail = 0;

    function __construct($lib){
        $this->lib = $lib;
    }

    protected function assertLessThanOrEqual($value, $compare){
        if($compare <= $value){
            echo 'pass';
        } else {
            $this->fail = 1;
            echo 'fail';
        }
    }

    protected function assertLessThan($value, $compare){
        
        if($compare < $value){
            echo 'pass';
        } else {
            $this->fail = 1;
            echo 'fail';
        }
    }

    protected function assertGreaterThan($value, $compare){
        
        if($compare > $value){
            echo 'pass';
        } else {
            $this->fail = 1;
            echo 'fail';
        }
    }

    protected function assertEquals($value, $compare){
        
        if($compare === $value){
            echo 'pass';
        } else {
            $this->fail = 1;
            echo 'fail';
        }
    }

    protected function assertTrue($compare){
        
        if($compare === true){
            echo 'pass';
        } else {
            $this->fail = 1;
            echo 'fail';
        }
    }

    protected function assertFalse($compare){
        
        if($compare === false){
            echo 'pass';
        } else {
            $this->fail = 1;
            echo 'fail';
        }
    }

    public static function run($lib, $className){
        $reflectedClass = new ReflectionClass($className);
        $instance = $reflectedClass->newInstance($lib);

        echo "Starting test \n";
        echo "PHP version: ".PHP_VERSION." \n\n";

        echo $reflectedClass->name."\n";
        echo "Deleting out dir...\n";
        self::rmdirRecursive($lib.'tests/out');
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
    }

    public static function rmdirRecursive($dir) {
        foreach (scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) {
                continue;
            }
            if (is_dir("$dir/$file")) {
                rmdirRecursive("$dir/$file");
            } else {
                unlink("$dir/$file");
            }
        }
        return rmdir($dir);
    }
}