<?php
    // nav and conn
    require("nav.php");
    require("conn.php");

    session_start();
    $uid = $_SESSION['id'];

    // find the users that the user follow
    $sql = $conn->prepare("SELECT * FROM `following` WHERE follower = '$uid'");
    $sql->execute();
    $rst = $sql->fetchAll();
    $following = array_column($rst, "following");

    // order the posts by the most recent time
    $sql = $conn->prepare("SELECT * FROM `post` ORDER BY `postTime` DESC");
    $sql->execute();
    $rst = $sql->fetchAll();
    $post_user = array_column($rst, "userID");
    $post_id = array_column($rst, "postID");

    // find the posts that are owned by users followed by the user
    for ($x = 0; $x <= count($post_user)-1; $x++) {
        for ($y = 0; $y <= count($following)-1; $y++) {
            if ($post_user[$x] == $following[$y]) {
                $id = $following[$y];
                $pid = $post_id[$x];

                // collect poster info
                $sql = $conn->prepare("SELECT * FROM user WHERE userID = '$id'");
                $sql->execute();
                $rst = $sql->fetch();
                $uname = $rst["name"];
                
                // collect post info
                $sql = $conn->prepare("SELECT * FROM post WHERE postID = '$pid'");
                $sql->execute();
                $rst = $sql->fetchAll();
                $photo = array_column($rst, "pic");
                $text = array_column($rst, "content");
                $time = array_column($rst, "postTime");
                
                // display post pic
                echo "<div>";
                echo '<img src="data:image/jpeg;base64,' . base64_encode($photo[0]) . '" style="width:350;height:auto"/>' . "<br>";

                // like icon (liked or unliked)
                $haveMatch = 0;
                $sql = $conn->prepare("SELECT * FROM `like` WHERE postID = '$pid'");
                $sql->execute();
                $rst = $sql->fetchAll();
                $userID = array_column($rst, "userID");
                for ($z = 0; $z <= count($userID)-1; $z++) {
                    if ($userID[$z] == $uid) {
                        $haveMatch = 1;
                        echo "
                        <a href='likeHandler.php?pid=$pid&like=$haveMatch'>
                        <img src='https://www.pinclipart.com/picdir/big/87-877828_save-the-heart-by-ofirma85-instagram-like-icon.png' style='width:21.5;height:auto'>
                        </a>";
                        break;
                    }
                }
                if ($haveMatch == 0) {
                    echo "
                    <a href='likeHandler.php?pid=$pid&like=$haveMatch'>
                    <img src='http://cdn.onlinewebfonts.com/svg/img_491354.png' style='width:20;height:auto'>
                    </a>";
                }

                // comment icon that leads the user to an individual page where the user can comment and see other comments
                echo "
                <a href='commentHandler.php?pid=$pid&c=0'>
                <img src='http://cdn.onlinewebfonts.com/svg/img_420387.png' style='width:20;height:auto'>
                </a>";

                // icon that leads the user to a page that displays a list of user who liked the post
                echo "<a href='likeUser.php?pid=$pid&c=0'>
                <img src='https://static.thenounproject.com/png/1939909-200.png' style='height:18.5;width:auto;'>
                </a>";

                // display post info
                echo "<br>";
                echo "<u class=\"uname\">" . $uname . " " . "</u>";
                echo $text[0] . "<br>";
                echo "<u class=\"gray\">" . $time[0] . "</u>";
                echo "</div>";
                echo "<br>";
            }
        }
    }
?>