<html>
<link rel="stylesheet" href="app.css">
</html>
<?php
    $uname = $_POST['username'];
    $loginPass = $_POST['password'];

    require("conn.php");

    // get array of user info
    $sql = $conn->prepare("SELECT * FROM user");
    $sql -> execute();
    $rst = $sql -> fetchAll();
    $id = array_column($rst, "userID");
    $user = array_column($rst, "name");
    $mail = array_column($rst, "email");
    $pass = array_column($rst, "password");
    $haveMatch = 0;

    // match hashed password for the row that the username is found
    for($x = 0; $x <= count($user); $x++) {
        if (strcmp($user[$x], $uname) == 0 && password_verify($loginPass, $pass[$x])) {
            session_start();
            $_SESSION['username'] = $user[$x];
            $_SESSION['email'] = $mail[$x];
            $_SESSION['id'] = $id[$x];
            
            header("refresh:0 ; url = firstPage.php");

            $haveMatch = 1;
            break;
        }
    }
    
    // if password not match, return to login
    if ($haveMatch == 0) {
        echo "Incorrect username or password, redirecting to login page in 2 seconds.";
        header("refresh:2 ; url = logIn.php");
    }
?>