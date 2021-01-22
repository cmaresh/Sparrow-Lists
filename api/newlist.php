<?php
session_start();
$id = $_POST['user'];
$name = $_POST['name'];

include '../templates/config.tpl.php';

if (strcmp($id, $_SESSION['user']) !== 0) {
    echo json_encode( array( 'error' => 'you are not the owner of this list' ));
    $conn->close();
    exit;
}

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