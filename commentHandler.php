<?php
    require("conn.php");

    if (isset($_POST['comment'])) {
        session_start();
        $uid = $_SESSION['id'];
        $pid = $_POST['pid'];
        $content = $_POST['comment'];
        $content = addslashes($content);
        $sql = $conn->prepare("INSERT INTO comment (postID, userID, content) VALUES ('$pid', '$uid', '$content')");
        $sql->execute();
        header("refresh:0");
    }

    if (isset($_POST['deleteComment'])) {
        $id = $_POST['id'];
        $sql = $conn->prepare("DELETE FROM comment WHERE commentID = $id");
        $sql->execute();
        header("refresh:0");
    }
?>

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

$sql = $conn->prepare("SELECT * FROM `user` WHERE userID = '$uid'");
$sql->execute();
$rst = $sql->fetchAll();

$photo = array_column($rst, "profilePic");
$name = array_column($rst, "name");
echo "<div class=\"comment\">";
echo '<img src="data:image/jpeg;base64,' . base64_encode($photo[0]) . '" style="width:50;height:auto;float:left"/>' . "<br>";
echo "
<form method=\"POST\" style=\"display:inline\">
<u class=\"uname\">$name[0]</u>
<input type=\"text\" name=\"pid\" value=$pid style=\"display:none\">
<input type=\"text\" name=\"comment\" class=\"comment\" placeholder=\"Say something...\" style=\"margin-top: 8px; width:250px\">
<input type=\"submit\" value=\"Comment\">
</form>
";
echo "</div>";

$sql = $conn->prepare("SELECT * FROM comment WHERE postID = '$pid' ORDER BY commentTime DESC");
$sql->execute();
$rst = $sql->fetchAll();

$commentID = array_column($rst, "commentID");
$commenter = array_column($rst, "userID");
$comment = array_column($rst, "content");
$time = array_column($rst, "commentTime");

for ($x = 0; $x <= count($commentID) - 1; $x++) {
    $sql = $conn->prepare("SELECT * FROM user WHERE userID = '$commenter[$x]'");
    $sql->execute();
    $rst = $sql->fetchAll();
    $photo = array_column($rst, "profilePic");
    $uname = array_column($rst, "name");

    echo "<div class=\"comment\">";
    echo '<img src="data:image/jpeg;base64,' . base64_encode($photo[0]) . '" style="width:50;height:auto;float:left;margin-right:10px"/>' . "<br>";
    echo "<u class=\"uname\">" . $uname[0] . " " . "</u>";
    echo $comment[$x] . "<br>";
    echo $time[$x];
    if ($commenter[$x] == $uid) {
        echo "<div class=\"right\" style=\"display: inline;\">";
        echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
        echo "<a href='editComment.php?cid=$commentID[$x]&c=$c&pid=$pid'>Edit</a>" . "&nbsp&nbsp";
        echo "<form method=\"post\" style=\"display:inline\"><input type=\"text\" name=\"id\" value=$commentID[$x] style=\"display:none\"><input type=\"submit\" name=\"deleteComment\" value=\"Delete\" style=\"
            background: none;
            border: none;
            font-size: 16px;
            padding: 0;
            font-family: 'Times New Roman', Times, serif;
            color: blue;
            cursor: pointer;
            \"></form>" . "<br></div>";
    }
    echo "</div>";
}
?>