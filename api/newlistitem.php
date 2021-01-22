<?php
session_start();
$user = $_POST['user'];
$content = $_POST['content'];
$parent = $_POST['parent'];

include '../templates/config.tpl.php';

if (strcmp($user, $_SESSION['user']) !== 0) {
    echo json_encode( array( 'error' => 'you are not the owner of this list' ));
    $conn->close();
    exit;
}


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