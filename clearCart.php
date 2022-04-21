<?php
    // CLEAR CART
    session_start();
    unset($_SESSION['cart'][$_GET['id']]);
    header('Location: /cart.php');

