<?php
    session_destroy();
    setcookie('username',"", -1, '/');
    header("Location: index.php");
?>