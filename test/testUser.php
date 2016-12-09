<?php 

include '../src/User.php';

class testUser extends PHPUnit_Framework_TestCase {
   
    protected function setUp() {
        parent::setUp();
        $this->newUser = new User();
    }
    
    protected function tearDown() {
        $this->newUser = null;
        parent::tearDown();
    }
    
    public function testInstanceObject() {
        $this->assertTrue(($this->newUser instanceof User));
    }
    
    public function testGetId() {
        $this->assertSame($this->newUser->getId(), -1);
    }
    
    public function testGetFirstName() {
        $this->assertSame($this->newUser->getFirstName(), "");
    }
    
    public function testGetLastName() {
        $this->assertSame($this->newUser->getLastName(), "");
    }
    
    public function testGetEmail() {
        $this->assertSame($this->newUser->getEmail(), "");
    }
    
    public function testGetHashedPassword() {
        $this->assertSame($this->newUser->getHashedPassword(), "");
    }
    
    public function testGetAddress() {
        $this->assertSame($this->newUser->getAddress(), "");
    }

    public function testSetFirstName(){
        $this->newUser->setFirstName("michal");
        $this->assertSame("michal", $this->newUser->getFirstName());
    }
    
    public function testSetLastName(){
        $this->newUser->setLastName("kowalski");
        $this->assertSame("kowalski", $this->newUser->getLastName());
    }
    
    public function testSetEmail(){
        $this->newUser->setEmail("michal@gmail.com");
        $this->assertSame("michal@gmail.com", $this->newUser->getEmail());
    }
    
    public function testSetAddress(){
        $this->newUser->setAddress("adres");
        $this->assertSame("adres", $this->newUser->getAddress());
    }
    
    //powtórzyć testy getów wszystkich.
    
    
   
    
}


?><?php ?>