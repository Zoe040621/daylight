<?php
    require("conn.php");

    session_start();
    $uid = $_SESSION['id'];
    $pid = $_GET['pid'];
    $like = $_GET['like'];

    // statements are used to identify where the refresh statement will direct the page to
    if ($like == 0) {
        $sql = $conn->prepare("INSERT INTO `like` (postID, userID) VALUES ('$pid', '$uid')");
        $sql->execute();
        header("refresh:0 ; url = home.php");
    } else if ($like == 1) {
        $sql = $conn->prepare("DELETE FROM `like` WHERE postID = '$pid' && userID = '$uid'");
        $sql->execute();
        header("refresh:0 ; url = home.php");
    } else if ($like == 2) {
        $sql = $conn->prepare("DELETE FROM `like` WHERE postID = '$pid' && userID = '$uid'");
        $sql->execute();
        header("refresh:0 ; url = liked.php");
    } else if ($like == 4) {
        $sql = $conn->prepare("INSERT INTO `like` (postID, userID) VALUES ('$pid', '$uid')");
        $sql->execute();
        header("refresh:0 ; url = myPage.php");
    } else {
        $sql = $conn->prepare("DELETE FROM `like` WHERE postID = '$pid' && userID = '$uid'");
        $sql->execute();
        header("refresh:0 ; url = myPage.php");
    }

?>