<?php
    session_start();
    $uid = $_SESSION['id'];
    $uname = $_SESSION['username'];
    $mail = $_POST['email'];
    $bio = $_POST['info'];
    $bio = addslashes($bio);

    require("conn.php");

    if ($_FILES['upload']['error'] === 0) {
        $photo = file_get_contents($_FILES['upload']['tmp_name']);
        $photo = addslashes($photo);    
        $sql = "UPDATE user SET
        `email` = '$mail',
        `bio` = '$bio',
        `profilePic` = '$photo'
        WHERE `userID` = '$uid'";
        $conn->exec($sql);    
    } else {
        $sql = "UPDATE user SET
        `email` = '$mail',
        `bio` = '$bio'
        WHERE `userID` = '$uid'";
        $conn->exec($sql);
    }

    $_SESSION['email'] = $mail;

    header("refresh:0 ; url = myPage.php");
?>