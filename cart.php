<?php
require_once "vendor/autoload.php";
use App\DB;
$db = new DB();
session_start();
$cart = $_SESSION["cart"] ?? [];
$goods = [];
$total_price = 0;

foreach ($cart as $key => $count) {
    $good = $db->get_good_by_id($key);
    $goods[] = [
        "good" =>  $good,
        "count" => $count
    ];
    $total_price += $count * $good["Price"];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $phone = $_POST["phone"];
    $mail = $_POST["mail"];
    $comment = $_POST["comment"];
    $order_id = $db->add_order($phone, $mail, $comment, $total_price);

    foreach ($goods as $good) {
        $db->add_order_item($order_id, $good["good"]["id"], $good["count"], $good["good"]["Price"]);
    }

    // Очистка корзины
    $_SESSION["cart"] = [];
    header("Location: order_success.php");
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Корзина</title>
    <link rel="stylesheet" href="assets/css/common.css">
    <link rel="stylesheet" href="assets/css/cart.css">
</head>
<body>

<?php include "include/header.php"; ?>

<main>
    <h1>Корзина</h1>
    <div class="goods">
        <?php foreach ($goods as $good): ?>
            <a href="good.php?id=<?= $good["good"]["id"] ?>" class="good">
                <div class="image">
                    <img src="assets/goods/<?= $good["good"]["Cover"] ?>" alt="">
                </div>
                <div class="text">
                    <p class="name"><?= $good["good"]["Name"] ?></p>
                    <p class="id"><?= $good["good"]["Price"]?> * <?= $good["count"] ?></p>
                </div>
                <div class="price">
                    <p><?= $good["good"]["Price"] * $good["count"] ?></p>
                    <button class="delete_button" data-id="<?= $good["good"]["id"] ?>">
                        <img src="assets/images/delete-svgrepo-com.svg" alt="">
                    </button>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="total">
        <p class="text">Общая стоимость:</p>
        <p class="price"><?= number_format($total_price, 0, null, " ") ?></p>
    </div>
    <div class="order">
        <form action="" method="post" autocomplete="off">
            <label for="phone">Телефон</label>
            <input type="text" id="phone" name="phone" required>
            <label for="mail">Эл.почта</label>
            <input type="email" id="mail" name="mail" required>
            <label for="comment">Комментарий</label>
            <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
            <button type="submit">Заказать</button>
        </form>
    </div>
</main>

<script src="assets/js/script.js"></script>
</body>
</html>
