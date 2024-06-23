<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);
$id = $data["id"];

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

if (isset($_SESSION["cart"][$id])) {
    $_SESSION["cart"][$id]++;
} else {
    $_SESSION["cart"][$id] = 1;
}

echo json_encode(["success" => true]);
?>

