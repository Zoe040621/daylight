<?php
    require("nav.php");
    require("conn.php");

    session_start();
    $uid = $_SESSION['id'];

    $sql = $conn->prepare("SELECT postID FROM `like` WHERE userID = '$uid'");
    $sql->execute();
    $rst = $sql -> fetchAll();
    $postID = array_column($rst, "postID");

    for ($x = 0; $x <= count($postID)-1; $x++) {
        $pid = $postID[$x];
        $sql = $conn->prepare("SELECT * FROM `post` WHERE postID = '$pid'");
        $sql->execute();
        $rst = $sql->fetchAll();

        $photo = array_column($rst, "pic");
        $text = array_column($rst, "content");
        $time = array_column($rst, "postTime");
        $postppl = array_column($rst, "userID");

        $sql = $conn->prepare("SELECT * FROM `user` WHERE userID = '$postppl[0]'");
        $sql->execute();
        $rst = $sql->fetchAll();

        $uname = array_column($rst, "name");

        echo "<div>";
        echo '<img src="data:image/jpeg;base64,' . base64_encode($photo[0]) . '" style="width:400;height:auto"/>' . "<br>";
        $haveMatch=2;
        echo "
            <a href='likeHandler.php?pid=$pid&like=$haveMatch'>
            <img src='https://www.pinclipart.com/picdir/big/87-877828_save-the-heart-by-ofirma85-instagram-like-icon.png' style='width:21.5;height:auto'>
            </a>
            <br>";
        echo "<u class='uname'>" . $uname[0] . " " . "</u>";
        echo $text[0] . "<br>";
        echo $time[0];
        echo "</div>";
        echo "<br>";
    }
?>