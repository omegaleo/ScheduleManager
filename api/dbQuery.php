<?php
    include('../functions.php');

    function ExecuteQueryAndReturnEncodedValue($query)
    {
        $check = checkToken($_POST['token'], $_POST['data']);
        if ($check !== false)
        {
            $myArray = array();
            $result = ExecuteQueryAndGetValue($query);

            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $myArray[] = $row;
            }

            echo json_encode($myArray);
        }
        else
        {
            echo "Invalid authorization token";
        }
    }
?>