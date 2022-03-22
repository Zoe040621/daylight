<html>
<link rel="stylesheet" href="app.css">
</html>

<?php
    require("nav.php");
?>

<html>
    <form action="searchHandle.php" method="POST">
        <input name="user" type="text" placeholder="Search user">
        <input type="submit" value="Search">
    </form>
</html>