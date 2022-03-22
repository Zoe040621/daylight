<?php
    // display list of users following the user or follower by the user
    $query = $conn->prepare("SELECT * FROM `user` WHERE userID = '$follow[$x]'");
    $query->execute();
    $rst = $query->fetch();
    $pic = $rst["profilePic"];
    $name = $rst["name"];
    $id = $rst["userID"];
    echo '<img src="data:image/jpeg;base64,' . base64_encode($pic) . '" style="width:50;height:auto"/>' . "<br>";
    echo $name . "<br>";
?>