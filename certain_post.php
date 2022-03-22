<?php
    // display info of certain post
    $sql = $conn->prepare("SELECT * FROM post WHERE postID = '$pid'");
    $sql->execute();
    $rst = $sql->fetchAll();

    $pu = array_column($rst, "userID");
    $photo = array_column($rst, "pic");
    $text = array_column($rst, "content");
    $time = array_column($rst, "postTime");

    $sql = $conn->prepare("SELECT * FROM user WHERE userID = '$pu[0]'");
    $sql->execute();
    $rst = $sql->fetchAll();
    $uname = array_column($rst, "name");
    $uname = $uname[0];

    echo "<div>";
    echo '<img src="data:image/jpeg;base64,' . base64_encode($photo[0]) . '" style="width:350;height:auto"/>' . "<br>";
    $haveMatch = 0;
    $sql = $conn->prepare("SELECT * FROM `like` WHERE postID = '$pid'");
    $sql->execute();
    $rst = $sql->fetchAll();
    $userID = array_column($rst, "userID");
    echo "<u class=\"uname\">" . $uname . " " . "</u>";
    echo $text[0] . "<br>";
    echo "<u class=\"gray\">" . $time[0] . "</u>";
    echo "</div>";
?>