<?php
    require("nav.php");
    require("conn.php");

    session_start();
    $uid = $_SESSION['id'];
    $user = $_SESSION['username'];
    $mail = $_SESSION['email'];

    $sql = $conn->prepare("SELECT * FROM `user` WHERE name LIKE '$user'");
    $sql->execute();
    $rst = $sql -> fetchAll();

    $pic = array_column($rst, "profilePic");
    $bio = array_column($rst, "bio");

    require("follow_query.php");

    echo "<br>" . '<img src="data:image/jpeg;base64,'.base64_encode($pic[0]).'" style="width:100;height:auto"/>';
    echo "<br><br><u class=\"uname\">" . $user . "</u><br>";
    echo count($follower) . " <a href=\"follow.php?name=follower\" class=\"follow\">Followers</a><br>";
    echo count($following) . " <a href=\"follow.php?name=following\" class=\"follow\">Following</a><br>";    
    echo "<p>";
    echo "<u class='bio'>" . $bio[0] . "</u><br><br>";
    echo "</p>";
?>

<html>
    <section class="link">
        <a href="edit.php">Edit Profile</a>
        <a href="logOut.php">Log Out</a>
    </section>
</html>

<?php
    echo "<br><br>";
    echo "Your Posts&nbsp";
    echo "<a href='liked.php'>Liked Posts</a>";
    require("conn.php");

    session_start();
    $uid = $_SESSION['id'];
    $uname = $_SESSION['username'];

    $sql = $conn->prepare("SELECT * FROM post WHERE userID = $uid ORDER BY postTime DESC");
    $sql->execute();
    $rst = $sql -> fetchAll();

    $pid = array_column($rst, "postID");
    $photo = array_column($rst, "pic");
    $text = array_column($rst, "content");
    $time = array_column($rst, "postTime");

    for($x = 0; $x <= count($pid)-1; $x++) {
        echo "<div>";
        echo '<img src="data:image/jpeg;base64,'.base64_encode($photo[$x]).'" style="width:350;height:auto"/>' . "<br>";
        echo "<a href='likeUser.php?pid=$pid[$x]&c=1'>
        <img src='https://static.thenounproject.com/png/1939909-200.png' style='height:18.5;width:auto;'>
        </a>";
    $haveMatch = 4;
        $sql = $conn->prepare("SELECT * FROM `like` WHERE postID = '$pid[$x]'");
        $sql->execute();
        $rst = $sql->fetchAll();
        $liker = array_column($rst, "userID");
        for ($z = 0; $z <= count($liker)-1; $z++) {
            if ($liker[$z] == $uid) {
                $haveMatch = 3;
                echo "
                <a href='likeHandler.php?pid=$pid[$x]&like=$haveMatch'>
                <img src='https://www.pinclipart.com/picdir/big/87-877828_save-the-heart-by-ofirma85-instagram-like-icon.png' style='width:21.5;height:auto'>
                </a>";
                break;
            }
        }
        if ($haveMatch == 4) {
            echo "
            <a href='likeHandler.php?pid=$pid[$x]&like=$haveMatch'>
            <img src='http://cdn.onlinewebfonts.com/svg/img_491354.png' style='width:20;height:auto'>
            </a>";
        }
        echo "
        <a href='commentHandler.php?pid=$pid[$x]&c=1'>
        <img src='http://cdn.onlinewebfonts.com/svg/img_420387.png' style='width:20;height:auto'>
        </a>
        <br>";
        echo "<u class=\"uname\">" . $uname . " " . "</u>";
        echo $text[$x] . "<br>";
        echo $time[$x];
        echo "</div>";
        echo "<br>";
    }
?>