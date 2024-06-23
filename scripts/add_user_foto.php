<?php
require_once "vendor/autoload.php";
use App\DB;
$db = new DB();
session_start();
$user_id = $_SESSION['user_id'] ?? 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];
    $foto = $_FILES["foto"]["name"];

    if ($user_id) {
        if (!empty($login)) {
            $db->update_user_login($user_id, $login);
        }
        if (!empty($password)) {
            $db->update_user_password($user_id, $password);
        }
        if (!empty($foto)) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($foto);
            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
            $db->update_user_foto($user_id, $target_file);
        }
        $_SESSION["message"] = "Данные обновлены";
    } else {
        $_SESSION["message"] = "Пользователь не авторизован";
    }
    header("Location: user.php");
    exit();
}