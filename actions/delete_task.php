<?php
    include("../functions.php");
    
    $id = $_GET['id'];

    $query = "DELETE FROM Tasks WHERE GUID='$id'";

    if(ExecuteQuery($query))
    {
         echo "<script>alert('Task Deleted!'); window.location.href='../index.php';</script>";
    }
    else
    {
        echo 'Error deleting task!';
    }
?>