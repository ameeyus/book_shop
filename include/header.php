<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if (isset($_SESSION["message"])) {
    $message = $_SESSION["message"];
    unset($_SESSION["message"]);
}
$user_id= $_SESSION["user_id"] ?? 0;
?>

<header>
    <div class="inner_container">
        <div class="toggle_menu">
            <img src="assets/image/menu.svg" alt="">
        </div>
        <nav>
            <ul>
                <li>
                    <a href="index.php">Главная</a>
                </li>
                <li>
                    <a href="#">Каталог</a>
                </li>
                <li>
                    <a href="#">О нас</a>
                </li>
            </ul>
        </nav>
        <form action="" class="search-form">
            <label class="search-label">
                <input name="query" type="text" placeholder="Я ищу...">
            </label>
        </form>
        <div class="icons">
            <a href="cart.php">
                <img src="assets/image/cart-shopping-fast.svg" alt="">
            </a>
            <a href="user.php">
                <img src="assets/image/person-fill.svg" alt="">
            </a>
            <a id="search-icon" href="javascript:void(0)">
                <img src="assets/image/search-alt.svg" alt="search" class="search-icon">
            </a>
        </div>
    </div>
</header>
<div class="popup">
    <div id="popup_message" class="<?= isset($message) ? 'active' : '' ?>">
        <div class="center">
            <p><?= $message ?? '' ?></p>
        </div>
</div>

