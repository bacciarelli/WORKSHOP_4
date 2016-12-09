<?php

include '../src/Item.php';

class testItemDB extends PHPUnit_Extensions_Database_TestCase {
    
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