<?php
require_once "vendor/autoload.php";
use App\DB;
session_start();
$db = new DB();

$user_id = $_SESSION['user_id'] ?? 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_account'])) {
        // Удалить аккаунт
        $db->delete_user($user_id);
        session_destroy();
        header("Location: user.php");
        exit();
    } elseif (isset($_POST['delete_photo'])) {
        // Удалить только фотографию
        $db->delete_user_photo($user_id);
        $_SESSION["message"] = "Фотография удалена";
        header("Location: user.php");
        exit();
    } else {
        // Обновить данные пользователя
        $login = $_POST["login"];
        $password = $_POST["password"];
        $foto_url = $_POST["foto_url"];

        if ($user_id) {
            if (!empty($login)) {
                $db->update_user_login($user_id, $login);
            }
            if (!empty($password)) {
                $db->update_user_password($user_id, $password);
            }
            if (!empty($foto_url)) {
                $db->update_user_foto($user_id, $foto_url);
            }
            $_SESSION["message"] = "Данные обновлены";
        } else {
            $_SESSION["message"] = "Пользователь не авторизован";
        }
        header("Location: user.php");
        exit();
    }
}

// Получить данные пользователя
$user = $db->get_user($user_id);
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/common.css">
    <?php if ($user_id): ?>
        <link rel="stylesheet" href="assets/css/foto.css">
    <?php else: ?>
        <link rel="stylesheet" href="assets/css/login.css">
    <?php endif; ?>
    <title>proba</title>
</head>
<body>

<?php include "include/header.php" ?>


<?php
if ($user_id) {
    include "include/foto_user.php";
}
else{
    include "include/user_login.php";
}
?>

</body>
<script src="assets/js/user.js"></script>
<script src="assets/js/script.js"></script>
</html>