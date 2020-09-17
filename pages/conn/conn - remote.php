<?php
$conn = mysqli_connect("db750943115.db.1and1.com", "dbo750943115", "4Dminc0nter@4773", "db750943115");

if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}


?>