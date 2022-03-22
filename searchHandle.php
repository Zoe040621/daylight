<?php
    require("nav.php");
    session_start();
    $uname = $_SESSION['username'];

    require("conn.php");
    $user = $_POST["user"];

    // search for username LIKE the data entered
    $sql = $conn->prepare("SELECT * FROM `user` WHERE name LIKE ?");
    $user = "%$user%";
    $sql->bindParam(1, $user);
    $sql->execute();
    while ($rst = $sql -> fetch()) {
        // display result
        echo "<div>";
        echo '<img src="data:image/jpeg;base64,' . base64_encode($rst['profilePic']) . '" style="width:50;height:auto"/>' . "<br>";
        echo "<a href='otherProfile.php?name=$rst[name]'>$rst[name]</a>" . "<br>";
        echo "</div>";
    }
?>