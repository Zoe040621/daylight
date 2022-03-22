<?php
    // get list of following and followers involving the user
    $query = $conn->prepare("SELECT * FROM `following` WHERE following = '$uid'");
    $query->execute();
    $rst = $query->fetchAll();
    $follower = array_column($rst, "following");

    $data = $conn->prepare("SELECT * FROM `following` WHERE follower = '$uid'");
    $data->execute();
    $rst = $data->fetchAll();
    $following = array_column($rst, "follower");
?>