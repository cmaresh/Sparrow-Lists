<?php
session_start();
$id = $_POST['id'];

include './templates/config.tpl.php';

$sql = "SELECT owner FROM lists WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();

$result = $stmt->get_result();
if ($result) {
    $list = $result->fetch_assoc();
    if (strcmp($list['owner'], $_SESSION['user']) !== 0) {
        echo json_encode( array( 'error' => 'you are not the owner of this list', 'owner' => $list['owner'], 'user' => $_SESSION['user']));
        exit;
    }
}
$stmt->close();

$sql = "UPDATE lists SET locked = !locked WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();

$stmt->close();

$conn->close();

exit;