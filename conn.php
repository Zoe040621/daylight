<?php
    // connection to database
    
    $username = 'be284ce1d282ac';
    $pw = '637a76b6';
    $host = 'us-cdbr-east-05.cleardb.net';
    $db = 'heroku_e6bb006cadde687';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$db", $username, $pw);
        } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>