<html>
<link rel="stylesheet" href="app.css">
</html>
<?php
    require("conn.php");

    $cid = $_POST['cid'];
    $pid = $_POST['pid'];
    $c = $_POST['c'];
    $content = $_POST['comment'];

    // update comment content
    $sql = $conn->prepare("UPDATE comment SET content = '$content' WHERE commentID = '$cid'");
    if ($sql->execute()) {
        echo "Comment Updated!<br>";
    }

    echo "<br>";
    echo "<a href='commentHandler.php?pid=$pid&c=$c'>Back</a>";
?>