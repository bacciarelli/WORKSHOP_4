<?php
require_once("../src/connection.php");

$twitterArraysSQL = ["create table Admins(
                        id int AUTO_INCREMENT NOT NULL,
                        admin_name varchar(25) NOT NULL UNIQUE,
                        email varchar(255) NOT NULL UNIQUE,
                        hashed_password varchar(60) NOT NULL,
                        PRIMARY KEY(id))
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table Users(
                        id int AUTO_INCREMENT NOT NULL,
                        first_name varchar(140) NOT NULL,
                        last_name varchar(140) NOT NULL,
                        email varchar(255) NOT NULL UNIQUE,
                        hashed_password varchar(60) NOT NULL,
                        address varchar(255) NOT NULL,
                        PRIMARY KEY(id))                        
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table Messages(
                        id int AUTO_INCREMENT NOT NULL,
                        admin_id int NOT NULL,
                        user_id int NOT NULL,
                        message_text text NOT NULL,
                        creation_date DATETIME NOT NULL,
                        PRIMARY KEY(id),
                        FOREIGN KEY(admin_id) REFERENCES Admins(id),
                        FOREIGN KEY(user_id) REFERENCES Users(id))
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
                        item_name varchar(255) NOT NULL UNIQUE,
                        description varchar(255) NOT NULL,
                        price decimal(8, 2) NOT NULL,
                        stock_quantity int NOT NULL,
                        category_id int NOT NULL,
                        PRIMARY KEY(id),
                        FOREIGN KEY(category_id) REFERENCES Categories (id))
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
                        quantity int NOT NULL, 
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
     ENGINE=InnoDB, CHARACTER SET=utf8"
    ,
    "create table Categories(
                        id int AUTO_INCREMENT NOT NULL,
                        text varchar(60) NOT NULL,
                        PRIMARY KEY(id))
     ENGINE=InnoDB, CHARACTER SET=utf8"
    ];

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