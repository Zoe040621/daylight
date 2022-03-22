<?php
    $username = 'be284ce1d282ac';
    $password = '637a76b6';
    $hostname = 'us-cdbr-east-05.cleardb.net';
    $database = 'heroku_e6bb006cadde687';

    try {
        $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    }
?>