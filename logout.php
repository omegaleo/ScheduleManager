<?php
    if (isset($_COOKIE['Username'])) {
        unset($_COOKIE['Username']);
    }

    header("Location: index.php");
?>