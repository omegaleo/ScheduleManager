<?php
    include('dbQuery.php');

    $username = $_POST['username'];

    $userGUID = GetTableValue('Users', 'GUID', 'WHERE Username="'.$username.'"');

    ExecuteQueryAndReturnEncodedValue("SELECT * FROM Tasks WHERE UserGUID='$userGUID'");
?>