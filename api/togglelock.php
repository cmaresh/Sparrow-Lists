<?php
session_start();
$id = $_POST['id'];

$servername = "127.0.0.1:3306";
$username = "root";
$password = "";
$database = "sparrow";

$curruser = 1;

if (strcmp($id, $_SESSION['user']) !== 0) {
    echo json_encode( array( 'error' => 'you are not the owner of this list' ));
    exit;
}

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

$sql = "UPDATE lists SET locked = !locked WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();

$conn->close();

exit;