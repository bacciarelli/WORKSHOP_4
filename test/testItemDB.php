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

    protected function getConnection() {
        $conn = new PDO(
                $GLOBALS['DB_DSN'],
                $GLOBALS['DB_USER'],
                $GLOBALS['DB_PASSWD']
                );
        //$conn->getConnection()->query("set foreign_key_checks=0");
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_DBNAME']);
    }

    protected function getDataSet() {
        
        $dataXML = $this->createMySQLXMLDataSet('DB.xml');
        return $dataXML;
    }
    
    public function testDB() {
        $this->assertInstanceOf(Item::class, Item::loadItemById(4));
    }

}