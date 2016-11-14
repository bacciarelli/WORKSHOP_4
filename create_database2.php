<?php
require_once("connection.php");

$twitterArraysSQL = array(
    "create table Admins(
                        id int AUTO_INCREMENT NOT NULL,
                        
                        name varchar(25) NOT NULL UNIQUE,

                        email varchar(255) NOT NULL UNIQUE,
                        password varchar(60) NOT NULL,
                        PRIMARY KEY(id))
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table Users(
                        id int AUTO_INCREMENT NOT NULL,
                        name varchar(140) NOT NULL,
                        surname varchar(140) NOT NULL,                        
                        email varchar(255) NOT NULL UNIQUE,
                        password varchar(60) NOT NULL,
                        address varchar(255) NOT NULL,
                        PRIMARY KEY(id))                        
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table Messages(
                        id int AUTO_INCREMENT NOT NULL,
                        
                        admin_id int NOT NULL, /w poleceniu nie ma nic o nadawcy
                        
                        order_id int NOT NULL, /raczej: user_id
                        
                        message_text_id int NOT NULL,
                        PRIMARY KEY(id),
                        FOREIGN KEY(admin_id) REFERENCES Admins(id),
                        
                        FOREIGN KEY(order_id) REFERENCES Orders(id), /odwołanie do Users(id)
                        
                        FOREIGN KEY(message_text_id) REFERENCES Messages_text(id))
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table Messages_text(
                        id int AUTO_INCREMENT NOT NULL,
                        text varchar(255) NOT NULL,
                        PRIMARY KEY(id))
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table Status(
                        id int AUTO_INCREMENT NOT NULL,
                        text varchar(255) NOT NULL,
                        PRIMARY KEY(id))
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table Items(
                        id int AUTO_INCREMENT NOT NULL,
                        name varchar(255) NOT NULL UNIQUE,
                        description varchar(255) NOT NULL,
                        price decimal(8, 2) NOT NULL,
                        
                        stock_quantity int NOT NULL,
                        group varchar(25),
                       
                        PRIMARY KEY(id))
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table Images(
                        id int AUTO_INCREMENT NOT NULL,
                        item_id int NOT NULL,
                        path varchar(255) NOT NULL,
                        PRIMARY KEY(id),
                        FOREIGN KEY(item_id) REFERENCES Items(id))
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table Items_Orders(
                        id int AUTO_INCREMENT NOT NULL,
                        item_id int NOT NULL,
                        order_id int NOT NULL,
                        
                        status ???
                        
                        quantity int NOT NULL, /ilość raczej w tabeli pośredniej?
                        
                        PRIMARY KEY(id),
                        FOREIGN KEY(item_id) REFERENCES Items(id),
                        FOREIGN KEY(order_id) REFERENCES Orders(id))
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table Orders(
                        id int AUTO_INCREMENT NOT NULL,
                        user_id int NOT NULL,
                        status_id int NOT NULL,
                        PRIMARY KEY(id),
                        FOREIGN KEY(user_id) REFERENCES Users(id),
                        FOREIGN KEY(status_id) REFERENCES Status(id))
     ENGINE=InnoDB, CHARACTER SET=utf8");

foreach($twitterArraysSQL as $query){
    $result = $conn->query($query);
    if ($result === TRUE) {
        echo "Tabela zostala stworzona poprawnie<br>";
    } else {
        echo "Blad podczas tworzenia tabeli: " . $conn->error."<br>";
    }
}


$conn->close();
$conn = null;

?>