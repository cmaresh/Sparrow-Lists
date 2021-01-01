<?php
session_start();
$user = $_POST['user'];
$listId = $_POST['id'];

$servername = "127.0.0.1:3306";
$username = "root";
$password = "";
$database = "sparrow";

$curruser = 1;

if (strcmp($user, $_SESSION['user']) !== 0) {
    echo json_encode( array( 'error' => 'you are not the owner of this list' ));
    exit;
}

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

$sql = "DELETE FROM lists WHERE id = ".$listId;
$result = $conn->query($sql);

$sql = "DELETE FROM items WHERE parent = ".$listId;
$result = $conn->query($sql);

$conn->close();

echo json_encode(array( 'id' => $listId ));
exit;