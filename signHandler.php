<html>
<link rel="stylesheet" href="app.css">
</html>
<?php
$uname = $_POST['username'];
$mail = $_POST['email'];
$pass = $_POST['password'];
$confirm = $_POST['confirm'];
// check if the password entered two times are the same
if (strcmp($pass, $confirm) == 0) {
    $hashedPass = password_hash($pass, PASSWORD_BCRYPT);
    $hashedPass = addslashes($hashedPass);
    require("conn.php");
    
    // ensure that no other user uses the same username
    $sql = $conn->prepare("SELECT * FROM user");
    $sql -> execute();
    $rst = $sql -> fetchAll();
    $user = array_column($rst, "name");
    $haveMatch = 0;
    for($x = 0; $x <= count($user); $x++) {
        if (strcmp($user[$x], $uname) == 0) {
            echo "Username repeated, redirecting to Sign Up in 2 seconds.";
            header("refresh:2 ; url = signUp.php");
    
            $haveMatch = 1;
            break;
        }
    }
    if ($haveMatch == 0) {
        $sql = "INSERT INTO user (name, email, password) VALUES ('$uname', '$mail', '$hashedPass')";
        $conn->exec($sql);
    
        session_start();
    
        $_SESSION['username'] = $uname;
        $_SESSION['email'] = $mail;
    
        $query = $conn->prepare("SELECT * FROM `user` WHERE name LIKE ?");
        $query->bindParam(1, $uname);
        $query->execute();
        $rst = $query -> fetch();

        $_SESSION['id'] = $rst["userID"];

        header("refresh:0 ; url = firstPage.php");
    }
    
} else {
    echo "Password unmatch, redirecting to Sign Up in 2 seconds.";
    header("refresh:2 ; url = signUp.php");
}
?>