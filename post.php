<html>
<link rel="stylesheet" href="app.css">
</html>

<?php
    require("nav.php");
?>

<html>
    <form action="postHandle.php" method="POST" enctype="multipart/form-data">
        <label for="upload">Picture: </label>
        <input type="file" name="upload">
        <br><br>
        <label for="content">Text: </label>
        <input type="text" name="content">
        <input type="submit">
    </form>
</html>