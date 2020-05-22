<?php
    include('dbQuery.php');

    $username = $_POST['username'];

    $userGUID = GetTableValue('users', 'GUID', 'WHERE Username="'.$username.'"');

    ExecuteQueryAndReturnEncodedValue("SELECT * FROM Tasks WHERE UserGUID='$userGUID'");
?>