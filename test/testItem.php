<?php

include '../src/Item.php';

class testItem extends PHPUnit_Framework_TestCase {
    
    protected function setUp() {
        parent::setUp();
        $item = $this->newObject = new Item();
        $this->newObject->setItemName("czekolada mleczna");
        $this->newObject->setDescription("opis czekolady");
        $this->newObject->setPrice(3.99);
        $this->newObject->setStockQuantity(100);
        $this->newObject->setCategoryId(1);
    }
    
    protected function tearDown() {
        $this->newObject = null;
        parent::tearDown();
    }
    
    public function testInstanceOfObject() {
        $this->assertTrue($this->newObject instanceof Item);
    }
    
    public function testGetId() {
        $this->assertEquals(-1, $this->newObject->getId());
    }
    
    public function testGetItemName() {
        $this->assertSame("czekolada mleczna", $this->newObject->getItemName());
    }
    
    public function testGetPrice() {
        $this->assertSame(3.99, $this->newObject->getPrice());
    }
    
    public function testGetDescription() {
        $this->assertSame("opis czekolady", $this->newObject->getDescription());
    }
    
    public function testGetStockQuantity() {
        $this->assertSame(100, $this->newObject->getStockQuantity());
    }
    
    public function testGetCategoryId() {
        $this->assertSame(1, $this->newObject->getCategoryId());
    }
    
    public function testSetItemName() {
        $this->newObject->setItemName("czekolada ciemna");
        $this->assertEquals("czekolada ciemna", $this->newObject->getItemName());
    }
    
    public function testSetPrice() {
        $this->newObject->setPrice(1.99);
        $this->assertEquals(1.99, $this->newObject->getPrice());
    }
    
    public function testSetDescription() {
        $this->newObject->setDescription("nowy opis");
        $this->assertEquals("nowy opis", $this->newObject->getDescription());
    }
    
    public function testSetStockQuantity() {
        $this->newObject->setStockQuantity(1);
        $this->assertEquals(1, $this->newObject->getStockQuantity());
    }
    
    public function testSetCategoryId() {
        $this->newObject->setCategoryId(11);
        $this->assertEquals(11, $this->newObject->getCategoryId());
    }
}