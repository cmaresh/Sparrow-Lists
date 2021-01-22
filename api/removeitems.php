<?php
session_start();
$id = $_POST['listId'];
$removeIds = $_POST['ids'];

include '../templates/config.tpl.php';

$sql = "SELECT * FROM lists WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$list_data = $result->fetch_assoc();

if (strcmp($list_data['owner'], $_SESSION['user']) !== 0) {
    echo json_encode(array( 'error' => 'you are not the owner of this list'));
    $conn->close();
    exit;
}

if ($result->num_rows < 1) {
    echo json_encode(array( 'error' => 'list with this id does not exist', 'listId' => $id ));
    $conn->close();
    exit;
} 

$idString = "";
foreach($removeIds as $removeId) {
    $idString = $idString.$removeId.',';
}
$idString = substr($idString, 0, strlen($idString)-1);
$sql = "DELETE FROM items WHERE id IN (".$idString.")";

$result = $conn->query($sql);

$conn->close();

echo json_encode(array( 'ids' => $removeIds ));
exit;