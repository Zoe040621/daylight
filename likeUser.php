<html>
<link rel="stylesheet" href="app.css">
</html>

<?php

$c = $_GET['c'];
require("c_return.php");
require("conn.php");

session_start();
$uid = $_SESSION['id'];
$pid = $_GET['pid'];

require("certain_post.php");

// display people who liked the post
echo "People who liked the post:<br><br>";
for ($x = 0; $x <= count($userID)-1; $x++) {
    $query = $conn->prepare("SELECT * FROM `user` WHERE userID = '$userID[$x]'");
    $query->execute();
    $rst = $query -> fetch();
    $pic = $rst["profilePic"];
    $name = $rst["name"];
    echo "<div style='padding: 10px'>";
    echo '<img src="data:image/jpeg;base64,'.base64_encode($pic).'" style="width:50;height:auto"/>' . "<br>";
    echo $name . "<br></div>";
}
?>