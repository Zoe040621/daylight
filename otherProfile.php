<?php
    require("conn.php");

    $user = $_GET['name'];

    session_start();
    $id = $_SESSION['id'];

    // get the info of the user
    $sql = $conn->prepare("SELECT * FROM `user` WHERE name LIKE '$user'");
    $sql->execute();
    $rst = $sql->fetchAll();
    $uid = array_column($rst, "userID");
    $pic = array_column($rst, "profilePic");
    $bio = array_column($rst, "bio");

    $uid = $uid[0];

    // if click on unfollow delete from the follow table
    if (isset($_POST['unfollow'])) {
        $sql = $conn->prepare("DELETE FROM `following` WHERE following = '$uid' && follower = '$id'");
        $sql->execute();
        header("refresh:0");
    }

    // if click on follow insert into the follow table
    if (isset($_POST['follow'])) {
        $sql = $conn->prepare("INSERT INTO `following` (follower, following) VALUES ('$id', '$uid')");
        $sql->execute();
        header("refresh:0");
    }

    require("nav.php");

    // return the user back to his/her own page when clicked on his/her own
    if ($user === $_SESSION['username']) {
        header("refresh:0 ; url = myPage.php");
    }

    require("follow_query.php");

    // display info of the user
    echo "<div class='profile'>";
    echo '<img src="data:image/jpeg;base64,' . base64_encode($pic[0]) . '" style="width:100;height:auto"/>' . "<br><br>";
    echo "<u class='uname'>" . $user . "</u><br>";
    echo "<u class='gray'>" . $bio[0] . "</u><br><br>";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
    echo count($follower) . " Followers";
    echo "&nbsp&nbsp&nbsp";
    echo count($following) . " Following";
    echo "&nbsp&nbsp&nbsp";

    // get the follow info of the user
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

    // get the posts of the user
    $sql = $conn->prepare("SELECT * FROM post WHERE userID = $uid");
    $sql->execute();
    $rst = $sql->fetchAll();

    $pid = array_column($rst, "postID");
    $photo = array_column($rst, "pic");
    $text = array_column($rst, "content");
    $time = array_column($rst, "postTime");

    $uname = $_GET['name'];

    // echo the posts of the user
    for ($x = 0; $x <= count($pid) - 1; $x++) {
        echo "<div>";
        echo '<img src="data:image/jpeg;base64,' . base64_encode($photo[$x]) . '" style="width:400;height:auto"/>' . "<br>";
        echo "<u class='uname'>" . $uname . " " . "</u>";
        echo $text[$x] . "<br>";
        echo "<u class=\"gray\">" . $time[$x] . "</u>";
        echo "</div>";
        echo "<br>";
    }
?>