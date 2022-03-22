<?php
  session_start();
  $id = $_SESSION['id'];
  $photo = file_get_contents($_FILES['upload']['tmp_name']);
  $text = $_POST['content'];

  // insert pic into db and return to myPage (which will display post)
  require("conn.php");
  $sql = $conn->prepare("INSERT INTO post (userID, pic, content) VALUES (?, ?, ?)");
  $sql->bindParam(1, $id);
  $sql->bindParam(2, $photo);
  $sql->bindParam(3, $text);
  $sql->execute();
  header("refresh:0; url = myPage.php");
?>