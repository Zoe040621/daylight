<?php
    try {
        $conn = new PDO("mysql:host=localhost;dbname=photoSharingApp", 'root', 'babu040621');
    } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    }
?>