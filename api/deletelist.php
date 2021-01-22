<?php
session_start();
$user = $_POST['user'];
$listId = $_POST['id'];

include '../templates/config.tpl.php';

if (strcmp($user, $_SESSION['user']) !== 0) {
    echo json_encode( array( 'error' => 'you are not the owner of this list' ));
    $conn->close();
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