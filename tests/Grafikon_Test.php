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

}