<?php

include '../src/Item.php';

class testItem extends PHPUnit_Framework_TestCase {
    
    protected function setUp() {
        parent::setUp();
        $this->newObject = new Item();
    }
    
    protected function tearDown() {
        $this->newObject = null;
        parent::tearDown();
    }
    
    public function testInstanceOfObject() {
        
    }
}