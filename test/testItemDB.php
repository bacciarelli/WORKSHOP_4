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
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
    }

    protected function getDataSet() {
        
        $dataXML = $this->createXMLDataSet($xmlFile);
        return $dataXML;
    }
    
    public function testDB() {
        $tableNames = array('TEST_internet_shop_db');
        $dataSet = $this->getConnection()->createDataSet();
    }

}