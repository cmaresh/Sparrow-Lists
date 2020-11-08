<?php
$id = $_COOKIE['id'];
$content = $_POST['content'];
$parent = $_POST['parent'];

$servername = "127.0.0.1:3306";
$username = "root";
$password = "";
$database = "sparrow";

$curruser = 1;

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

$sql = "INSERT INTO items (parent, content) VALUES ({$parent}, '{$content}')";

$result = $conn->query($sql);

$id = $conn->insert_id;
$conn->close();

echo json_encode(array( 'id' => $id, 'content' => $content ));
exit;