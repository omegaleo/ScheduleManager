<?php
    include("../functions.php");
    $description = PrepareValue($_POST['desc']);
    $repeat="0";
    if(!empty($_POST['repeat']))
    {
       $repeat="1"; 
    }
    $repeatRate = $_POST['repeatRate'];
    $taskDate = $_POST['taskDate'];
    $dayOfWeek = $_POST['dayOfWeek'];
    $time = $_POST['time'];
    $userGUID = $_POST['userGUID'];
    $time = date('H:i:s', strtotime($time));

    $guid = gen_uuid();

    $query = "Insert into Tasks Values('','$guid','$description','$repeat','$repeatRate','$taskDate','$dayOfWeek','$time','$userGUID')";


    if(ExecuteQuery($query))
    {
        echo "<script>alert('Task Added!'); window.location.href='../index.php';</script>";
    }
    else
    {
        echo "<script>alert('Failed to add task!'); window.location.href='../index.php';</script>";
    }
?>