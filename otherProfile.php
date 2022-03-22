<?php
    require("conn.php");

$user = $_GET['name'];

session_start();
$id = $_SESSION['id'];

$sql = $conn->prepare("SELECT * FROM `user` WHERE name LIKE '$user'");
$sql->execute();
$rst = $sql->fetchAll();

$uid = array_column($rst, "userID");

$uid = $uid[0];

if (isset($_POST['unfollow'])) {
    $sql = $conn->prepare("DELETE FROM `following` WHERE following = '$uid' && follower = '$id'");
    $sql->execute();
    header("refresh:0");
}

if (isset($_POST['follow'])) {
    $sql = $conn->prepare("INSERT INTO `following` (follower, following) VALUES ('$id', '$uid')");
    $sql->execute();
    header("refresh:0");
}

require("nav.php");

$user = $_GET['name'];

session_start();

if ($user === $_SESSION['username']) {
    header("refresh:0 ; url = myPage.php");
}

$sql = $conn->prepare("SELECT * FROM `user` WHERE name LIKE '$user'");
$sql->execute();
$rst = $sql->fetchAll();

$mail = array_column($rst, "email");
$uid = array_column($rst, "userID");
$pic = array_column($rst, "profilePic");
$bio = array_column($rst, "bio");

$uid = $uid[0];

require("follow_query.php");

echo "<div class='profile'>";
echo '<img src="data:image/jpeg;base64,' . base64_encode($pic[0]) . '" style="width:100;height:auto"/>' . "<br><br>";
echo "<u class='uname'>" . $user . "</u><br>";
echo "<u class='bio'>" . $bio[0] . "</u><br><br>";
echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
echo count($follower) . " Followers";
echo "&nbsp&nbsp&nbsp";
echo count($following) . " Following";
echo "&nbsp&nbsp&nbsp";

$id = $_SESSION['id'];

$query = $conn->prepare("SELECT * FROM `following` WHERE follower = '$id'");
$query->execute();
$rst = $query->fetchAll();
$s_following = array_column($rst, "following");

$haveMatch = 0;

for ($x = 0; $x <= count($s_following); $x++) {
    if ($s_following[$x] == $uid) {
        echo "<form method=\"post\" style=\"display:inline;\"><input type=\"submit\" name=\"unfollow\" value=\"Unfollow\"></form>";
        $haveMatch = 1;
        break;
    }
}

if ($haveMatch == 0) {
    echo "<form method=\"post\" style=\"display:inline;\"><input type=\"submit\" name=\"follow\" value=\"Follow\"></form>";
}
echo "</div>";

$sql = $conn->prepare("SELECT * FROM post WHERE userID = $uid");
$sql->execute();
$rst = $sql->fetchAll();

$pid = array_column($rst, "postID");
$photo = array_column($rst, "pic");
$text = array_column($rst, "content");
$time = array_column($rst, "postTime");

$uname = $_GET['name'];

echo "<br><br><br>Posts";
for ($x = 0; $x <= count($pid) - 1; $x++) {
    echo "<div>";
    echo '<img src="data:image/jpeg;base64,' . base64_encode($photo[$x]) . '" style="width:400;height:auto"/>' . "<br>";
    echo "<u class='uname'>" . $uname . " " . "</u>";
    echo $text[$x] . "<br>";
    echo $time[$x];
    echo "</div>";
    echo "<br>";
}
?>