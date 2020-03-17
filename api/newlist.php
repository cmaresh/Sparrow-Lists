<?php
$id = $_COOKIE['id'];
$name = $_POST['name'];

$servername = "127.0.0.1:3309";
$username = "root";
$password = "";
$database = "sparrow";

$curruser = 1;

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

$sql = "INSERT INTO lists (owner, name) VALUES ({$id}, '{$name}')";

$result = $conn->query($sql);

$id = $conn->insert_id;
$conn->close();

echo json_encode(array( 'help' => 'test' ));
exit;