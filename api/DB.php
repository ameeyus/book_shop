<?php
namespace App;

use mysqli;

class DB {
    public $link;

    public function __construct() {
        $this->link = new mysqli("localhost", "root", "", "book");
    }

    public function get_good_by_id($id) {
        $id = $this->link->real_escape_string($id);
        $result = $this->link->query("SELECT * FROM `goods` WHERE id = '$id'");

        if ($result && $result->num_rows) {
            return $result->fetch_assoc();
        }
        return [];
    }

    private function escape_all(&...$params) {
        foreach ($params as &$param) {
            $param = $this->link->real_escape_string($param);
        }
    }

    public function add_order($phone, $mail, $comment, $total_price) {
        $this->escape_all($phone, $mail, $comment, $total_price);
        $this->link->query("INSERT INTO `orders` (`phone`, `mail`, `comment`, `total_price`) VALUES ('$phone', '$mail', '$comment', '$total_price')");
        return $this->link->insert_id;
    }

    public function add_order_item($order_id, $good_id, $count, $price) {
        $this->escape_all($order_id, $good_id, $count, $price);
        $this->link->query("INSERT INTO `order_items` (`order_id`, `good_id`, `count`, `price`) VALUES ('$order_id', '$good_id', '$count', '$price')");
    }

    public function check_new_login($login) {
        $this->escape_all($login);
        $user = $this->link->query("SELECT * FROM users WHERE login = '{$login}'");
        return $user && $user->num_rows;
    }

    public function add_user($login, $password) {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $this->escape_all($login, $password);
        $this->link->query("INSERT INTO `users` (`Login`, `Password`) VALUES ('$login', '$password');");
    }

    public function get_user_by_login($login) {
        $this->escape_all($login);
        $user = $this->link->query("SELECT * FROM users WHERE login = '{$login}'");
        if ($user && $user->num_rows) {
            return $user->fetch_assoc();
        }
        return [];
    }

    public function get_all_goods() {
        $result = $this->link->query("SELECT * FROM `goods`");
        if ($result && $result->num_rows) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function get_filtred_goods($category_id) {
        $category_id = $this->link->real_escape_string($category_id);
        $result = $this->link->query("SELECT * FROM `goods` WHERE `category_id` = '$category_id'");
        if ($result && $result->num_rows) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function delete_user($user_id) {
        $user_id = $this->link->real_escape_string($user_id);
        $this->link->query("DELETE FROM users WHERE id = '$user_id'");
    }

    public function delete_user_photo($user_id) {
        $user_id = $this->link->real_escape_string($user_id);
        $this->link->query("UPDATE users SET foto = NULL WHERE id = '$user_id'");
    }

    public function get_user($user_id) {
        $user_id = $this->link->real_escape_string($user_id);
        $result = $this->link->query("SELECT * FROM users WHERE id = '$user_id'");
        if ($result && $result->num_rows) {
            return $result->fetch_assoc();
        }
        return [];
    }

    public function get_categories() {
        $result = $this->link->query("SELECT * FROM `catalog`");
        if ($result && $result->num_rows) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function update_user_login($user_id, $login) {
        $this->escape_all($login);
        $this->link->query("UPDATE `users` SET `Login` = '$login' WHERE `id` = '$user_id'");
        return $this->link->errno == 0;
    }

    public function update_user_password($user_id, $password) {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $this->escape_all($password);
        $this->link->query("UPDATE `users` SET `Password` = '$password' WHERE `id` = '$user_id'");
        return $this->link->errno == 0;
    }

    public function update_user_foto($user_id, $foto_url) {
        $this->escape_all($foto_url);
        $this->link->query("UPDATE `users` SET `Foto` = '$foto_url' WHERE `id` = '$user_id'");
        return $this->link->errno == 0;
    }
}
?>
