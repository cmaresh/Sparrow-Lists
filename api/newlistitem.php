<?php
session_start();
$user = $_POST['user'];
$content = $_POST['content'];
$parent = $_POST['parent'];

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

$sql = "SELECT * FROM lists WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $parent);

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows < 1) {
    echo json_encode(array( 'error' => 'list with this id does not exist' ));
    exit;
}

$sql = "INSERT INTO items (parent, content) VALUES (?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $parent, $content);

$stmt->execute();

$id = $stmt->insert_id;
$conn->close();

echo json_encode(array( 'id' => $id, 'content' => $content ));
exit;