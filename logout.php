<?php
    session_destroy();
    setcookie('username',"", -1, '/');
    setcookie('notifiedtasks',"",-1, '/');
    header("Location: index.php");
?>