<?php
    include('../functions.php');

    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = GetConnection();
            $username = mysqli_real_escape_string($conn,$_POST["username"]);
            $password = Encrypt(mysqli_real_escape_string($conn,$_POST["password"]));
            $query = mysqli_query($conn,"SELECT * FROM `Users` WHERE `Username`='".$username."' AND `Password`='".$password."'");
            if(mysqli_num_rows($query) > 0)
            {
                auth($username);
            }

?>