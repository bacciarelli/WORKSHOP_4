<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="UTF-8">
    <title>Candy Shop</title>
</head>
<body>
    
    <?php
    if (!(isset($_SESSION['login']))) {
    ?>
    <form action="" method="POST">
        Podaj swój e-mail: <br>
        <input type="text" name ="email"/><br>
        Podaj swoje hasło:<br>
        <input type="password" name ="password"/><br><br>
        <input type="submit" value="Zaloguj się"/>
    </form>
    <p><a href="register.php">Zarejestruj się</a></p>
    <?php
    } else {
       echo '<a href="src/logout.php">Wyloguj się</a><br><br>';
    }
    ?>

    

</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);
    $sql = "SELECT * FROM Users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows == false) {
            exit("Zły login<br>");
        } else {
            $row = $result->fetch_assoc();
            $_SESSION ['userId'] = $row['id'];
            $_SESSION ['username'] = $row['username'];
            $userPass = $row['hashedPassword'];
            if (!password_verify($password, $userPass)) {
                exit("Złe hasło<br>");
            }
        }

        $result->free_result();
        $_SESSION['login'] = true;
        $conn->close();
        $conn = null;
        header('Location: ../index.php');
    }
}

?>