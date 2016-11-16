<?php 
include_once '../src/User.php';

            $newUser = User::loadUserById(1);
         
            var_dump($newUser);
       
            //$newUser->deleteUser();
            var_dump($newUser);

?>