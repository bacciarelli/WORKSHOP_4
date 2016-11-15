<?php

/**
 * Description of Cart
 *
 * @author a
 * @property type $name Description
 */
abstract class Cart {
    
    abstract protected function getCartQuantity ($itemId);
    
    abstract protected function getCartItems ();
    
    abstract protected function addToCart($itemId);
    
    abstract protected function removeFromCart($itemId);
    
    abstract protected function changeCartQuantity($newQuantity, $itemId);
    
    abstract protected function calculateCartTotal();
}