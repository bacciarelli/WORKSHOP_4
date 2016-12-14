<?php

//for any changes in src/ folder run: composer dump-autoload in console

class testItemDB extends PHPUnit_Extensions_Database_TestCase {

    private $item;
    
    protected function setUp() {
        parent::setUp();
        $this->newObject = new Item();
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

    protected function getConnection() {
        $conn = new PDO(
                $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']
        );
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_DBNAME']);
    }

    protected function getDataSet() {

        $dataXML = $this->createMySQLXMLDataSet('../test/DB.xml');
        return $dataXML;
    }

    public function testSaveItemToDB() {
        $this->assertTrue($this->newObject->saveItemToDB(), "Unable to save object to DB");
    }

    public function testDeleteFromDB() {
        $this->assertTrue(Item::deleteFromDB(6), "Unable to delete Item from DB");
    }

    public function testLoadItemById() {
        $this->assertInstanceOf(Item::class, Item::loadItemById(4));
    }

    public function testUpdateItem() {
        $item = Item::loadItemById(6);
        $item->setItemName("some new item name");
        $this->assertTrue($item->updateItem(), "unable to update item info");
    }
    
    public function testLoadItemsByCategory() {
        $this->assertCount(3, Item::loadItemsByCategory(5));
    }

    public function testLoadAllItems() {
        $this->assertCount(18, Item::loadAllItems());
    }

}