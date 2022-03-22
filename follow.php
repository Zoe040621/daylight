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

    if (strcmp($follow, "following") == 0) {
        $data = $conn->prepare("SELECT * FROM `following` WHERE follower = '$uid'");
        $data->execute();
        $rst = $data -> fetchAll();
        $following = array_column($rst, "following");

        for ($x = 0; $x <= count($following)-1; $x++) {
            $query = $conn->prepare("SELECT * FROM `user` WHERE userID = '$following[$x]'");
            $query->execute();
            $rst = $query -> fetch();
            $pic = $rst["profilePic"];
            $name = $rst["name"];
            $id = $rst["userID"];
            echo '<img src="data:image/jpeg;base64,'.base64_encode($pic).'" style="width:50;height:auto"/>' . "<br>";
            echo $name . "<br>";
            echo "<form method=\"post\"><input type=\"text\" name=\"id\" value=$id style=\"display:none\"><input type=\"submit\" name=\"removeFollowing\" value=\"Remove\"></form>" . "<br>";
        }
    } else {
        $sql = $conn->prepare("SELECT * FROM `following` WHERE following = '$uid'");
        $sql->execute();
        $rst = $sql -> fetchAll();
        $follower = array_column($rst, "follower");
        for ($x = 0; $x <= count($follower)-1; $x++) {
            $query = $conn->prepare("SELECT * FROM `user` WHERE userID = '$follower[$x]'");
            $query->execute();
            $rst = $query -> fetch();
            $pic = $rst["profilePic"];
            $name = $rst["name"];
            $id = $rst["userID"];
            echo '<img src="data:image/jpeg;base64,'.base64_encode($pic).'" style="width:50;height:auto"/>' . "<br>";
            echo $name . "<br>";
            echo "<form method=\"post\"><input type=\"text\" name=\"id\" value=$id style=\"display:none\"><input type=\"submit\" name=\"removeFollower\" value=\"Remove\"></form>" . "<br>";
        }
    }
?>