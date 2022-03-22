<?php
    require("conn.php");

    if (isset($_POST['removeFollowing'])) {
        session_start();
        $uid = $_SESSION['id'];
        $id = $_POST['id'];
        $sql = $conn->prepare("DELETE FROM `following` WHERE following = '$id' && follower = '$uid'");
        $sql->execute();
        header("refresh:0");
    }

    if (isset($_POST['removeFollower'])) {
        session_start();
        $uid = $_SESSION['id'];
        $id = $_POST['id'];
        $sql = $conn->prepare("DELETE FROM `following` WHERE following = '$uid' && follower = '$id'");
        $sql->execute();
        header("refresh:0");
    }
?>

<?php
    require("nav.php");
    $follow = $_GET['name'];
    require("conn.php");

    session_start();
    $uid = $_SESSION['id'];

    // if said following --> get who the user is following
    // if said follower --> get who follows the user
    if (strcmp($follow, "following") == 0) {
        $data = $conn->prepare("SELECT * FROM `following` WHERE follower = '$uid'");
        $data->execute();
        $rst = $data->fetchAll();
        $follow = array_column($rst, "following");
        // need for loop in both statements because the names of the remove button are different (remove following or follower)
        for ($x = 0; $x <= count($follow) - 1; $x++) {
            include("track_follow.php");
            echo "<form method=\"post\"><input type=\"text\" name=\"id\" value=$id style=\"display:none\"><input type=\"submit\" name=\"removeFollowing\" value=\"Remove\"></form>" . "<br>";
        }
    } else {
        $sql = $conn->prepare("SELECT * FROM `following` WHERE following = '$uid'");
        $sql->execute();
        $rst = $sql->fetchAll();
        $follow = array_column($rst, "follower");
        for ($x = 0; $x <= count($follow) - 1; $x++) {
            include("track_follow.php");
            echo "<form method=\"post\"><input type=\"text\" name=\"id\" value=$id style=\"display:none\"><input type=\"submit\" name=\"removeFollower\" value=\"Remove\"></form>" . "<br>";
        }
    }
?>