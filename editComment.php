<html>
<link rel="stylesheet" href="app.css">
</html>
<?php
    require("conn.php");

    session_start();
    $uid = $_SESSION['id'];
    $cid = $_GET['cid'];
    $c = $_GET['c'];
    $pid = $_GET['pid'];

    require("certain_post.php");

    // get user info
    $sql = $conn->prepare("SELECT * FROM `user` WHERE userID = '$uid'");
    $sql->execute();
    $rst = $sql->fetchAll();
    $photo = array_column($rst, "profilePic");
    $name = array_column($rst, "name");

    // get comment info
    $sql = $conn->prepare("SELECT * FROM comment WHERE commentID = $cid");
    $sql->execute();
    $rst = $sql->fetchAll();
    $content = array_column($rst, "content");
    $content = $content[0];

    // display comment info and put it in a form to submit change
    echo "<div class=\"comment\">";
    echo '<img src="data:image/jpeg;base64,' . base64_encode($photo[0]) . '" style="width:50;height:auto;float:left"/>' . "<br>";
    echo "
    <form method=\"POST\" action=\"ecHandler.php\" style=\"display:inline\">
    <u class=\"uname\">$name[0]</u>
    <input type=\"text\" name=\"pid\" value=$pid style=\"display:none\">
    <input type=\"text\" name=\"cid\" value=$cid style=\"display:none\">
    <input type=\"text\" name=\"c\" value=$c style=\"display:none\">
    <input type=\"text\" name=\"comment\" class=\"comment\" value=\"$content\" style=\"margin-top: 8px; width:250px\">
    <input type=\"submit\" value=\"Comment\">
    </form>
    ";
    echo "</div>";
    
?>