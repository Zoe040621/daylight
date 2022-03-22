<?php
    require("nav.php");
    session_start();
    echo "<br><br>Welcome to Daylight, " . $_SESSION['username'] . "!<br>";
?>