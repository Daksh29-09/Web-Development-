<?php
include 'db.php';

session_start();
$userId = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"));
$productId = $data->productId;

$sql = "INSERT INTO cart (user_id, product_id) VALUES ('$userId', '$productId')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
}
?>