<!DOCTYPE html>
<html lang="pl">
    <head>

        <meta charset="UTF-8">
        <title>Rejestrowanie</title>
    </head>
    <body>
        <form action="" method="POST">
            Podaj swoje imię: <br>
            <input type="text" name ="firstName"/><br>
            Podaj swoje nazwisko: <br>
            <input type="text" name ="lastName"/><br>
            Podaj swój e-mail: <br>
            <input type="text" name ="email"/><br>
            Podaj swój adres: <br>
            <input type="text" name ="address"/><br>
            Podaj swoje hasło:<br>
            <input type="password" name ="password"/><br><br>
            <input type="submit" value="Stwórz konto"/>
        </form>
        <p><a href="login.php">Zaloguj się</a></p>
    </body>
</html>

<?php
require_once '../src/User.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {


    $pattern = '/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]{1,})*\.([a-zA-Z]{2,}){1}$/';
    if (preg_match($pattern, $_POST['email']) == 0) {
        echo 'Podano niepoprawny e-mail!';
    } else {

        $address = $_POST['address'];
        $email = $_POST['email'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $password = $_POST['password'];

        if (User::checkEmail($email) == false) {
            if (User::registerNewUser($address, $email, $firstName, $lastName, $password) == true) {
                echo "zarejestrowano";
                $_SESSION['login'] = true;
                $newUser = User::loadUserByEmail($email);
                $_SESSION['user_id'] = $newUser->getId();
                header('Location: ../index.php');
            } else {
                echo "niezarejestrowano";
            }
        } else {
            echo "Użytkownik o podanym e-mailu już istnieje<br>";
        }



//        $newUser = new User();
//        $newUser->setAddress($address);
//        $newUser->setEmail($email);
//        $newUser->setFirstName($firstName);
//        $newUser->setLastName($lastName);
//        $newUser->setHashedPassword($password);
    }
}
?>
