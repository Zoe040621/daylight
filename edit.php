<?php
    require("nav.php");
    require("conn.php");

    session_start();
    $uid = $$_SESSION['id'];
    $user = $_SESSION['username'];
    $mail = $_SESSION['email'];

    $sql = $conn->prepare("SELECT * FROM `user` WHERE name LIKE '$user'");
    $sql->execute();
    $rst = $sql -> fetchAll();

    $pic = array_column($rst, "profilePic");
    $bio = array_column($rst, "bio");

    echo "Profile Pic: " . "<br>";
    echo "<br>" . '<img src="data:image/jpeg;base64,'.base64_encode($pic[0]).'" style="width:100;height:auto" alt="N/A"/>';
?>
<html>
    <form action="editHandler.php" method="POST" enctype="multipart/form-data">
        <br>
        <label for="upload">Upload New: </label>
        <input type="file" name="upload">
        <br><br>
        <label for="username">Username: <?php echo $user;?></label>
        <br><br>
        <label for="email">Email: </label>
        <input type="email" name="email" value = <?php echo $mail;?>>
        <br><br>
        <label for="info">Bio: </label>
        <!-- <input type="text" name="info" value = <?php echo $bio[0];?>> -->
        <textarea name="info"><?php echo $bio[0];?></textarea>
        <br><br>
        <input type="submit" name="submit" value="Update">
    </form>
    <section class="link">
        <a href="myPage.php">Cancel</a>
    </section>
</html>