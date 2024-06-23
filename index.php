<?php
require_once('vendor/autoload.php');
use App\DB;
$db = new DB();
if (isset($_GET["category_id"])) {
    $goods = $db->get_filtred_goods($_GET["category_id"]);
}
else {
    $goods = $db->get_all_goods();
}

$categories = $db->get_categories();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/common.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Document</title>
</head>
<body>
<?php include "include/header.php"?>
<main>
    <div class="goods">
        <?php foreach ($goods as $good): ?>
        <a href="good.php?id<?= $good["id"] ?>" class="good">
            <div class="image">
                <img src="<?= $good["Cover"] ?>">
            </div>
            <p class="name"><?= $good["Name"] ?></p>
            <p class="price"><?= number_format($good["Price"],0, null,"")?></p>
            <button class="add_to_cart" data-id="<?= $good["id"] ?>">В корзину</button>
        </a>
        <?php endforeach; ?>
    </div>
</main>
<script src="assets/js/script.js"></script>
</body>
</html>