<main>
    <div class="container">
        <h1>Изменение данных пользователя</h1>
        <?php if (isset($_SESSION["message"])): ?>
            <p><?= $_SESSION["message"] ?></p>
            <?php unset($_SESSION["message"]); ?>
        <?php endif; ?>
        <div class="user-container">
            <p>Логин: <?= htmlspecialchars($user['Login']) ?></p>
            <p>Пароль: <?= str_repeat('*', strlen($user['Password'])) ?></p>
            <?php if (!empty($user['Foto'])): ?>
                <img src="<?= htmlspecialchars($user['Foto']) ?>" alt="Фото профиля">
            <?php else: ?>
                <p>Фото отсутствует</p>
            <?php endif; ?>
            <form action="user.php" method="post" onsubmit="return confirmDeleteAccount();">
                <button type="submit" name="delete_account">Удалить аккаунт</button>
            </form>
            <form action="user.php" method="post" onsubmit="return confirmDeletePhoto();">
                <button type="submit" name="delete_photo">Удалить фотографию</button>
            </form>
            <form action="scripts/logout.php" method="post">
                <button type="submit" name="logout">Выйти из аккаунта</button>
            </form>
        </div>
        <form action="user.php" method="post">
            <label for="login">Новый логин:</label>
            <input type="text" name="login" id="login">
            <label for="password">Новый пароль:</label>
            <input type="password" name="password" id="password">
            <label for="foto_url">URL фотографии профиля:</label>
            <input type="text" name="foto_url" id="foto_url">
            <button type="submit">Обновить</button>
        </form>
    </div>
</main>
<script>
    function confirmDeleteAccount() {
        return confirm('Вы уверены, что хотите удалить аккаунт? Это действие необратимо.');
    }

    function confirmDeletePhoto() {
        return confirm('Вы уверены, что хотите удалить фотографию? Это действие необратимо.');
    }
</script>