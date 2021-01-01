<?php
session_start();
$id = $_POST['user'];
$name = $_POST['name'];

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

$sql = "SELECT * FROM users WHERE email = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);

$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows < 1) {
    echo json_encode(array( 'error' => 'user does not exist' ));
    exit;
}

$sql = "INSERT INTO lists (owner, name) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $id, $name);

$result = $stmt->execute();

$id = $stmt->insert_id;
$conn->close();

echo json_encode(array( 'id' => $id, 'name' => $name ));
exit;