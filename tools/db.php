<?php
    eval(file_get_contents(GetRootFolder()."/configurations/db.php"));
    function GetConnection()
    {

        $host = constant("DBHost");
        $username = constant("DBUsername");
        $password = constant("DBPassword");
        $dbname = constant("DBName");
        $dbPort = constant("DBPort");

            $conn = new mysqli($host,$username,$password,$dbname,$dbPort);
            $conn->set_charset("utf8");
            if ($conn->connect_error)
            {
                //Later make a function to log every error
                echo $conn->connect_error;
            }
            else
            {
                $conn->select_db($dbname);
                return $conn;
            }
    }

    function ExecuteQueryAndGetValue($query)
    {
        $conn = GetConnection();
        $result = mysqli_query($conn,$query);

        if($result)
        {
            return $result;
        }
        else
        {
            return null;
        }
    }

    function GetTableValue($table, $column, $conditions="")
    {
        $conn = GetConnection();
        $result = mysqli_query($conn,'SELECT '.$column.' FROM '.$table. ' '.$conditions);
        $value = mysqli_fetch_assoc($result);

        return $value[$column];
    }

    function ExecuteQuery($query)
    {
        $conn = GetConnection();
        $result = mysqli_query($conn,$query);

        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function ExecuteExternalQuery($databaseName,$query)
    {
        $conn = GetConnection();
        $conn->select_db($databaseName);
        $result = mysqli_query($conn,$query);

        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function ExecuteExternalQueryAndGetTableValue($database,$query, $column)
    {
        $conn = GetConnection();
        $conn->select_db($databaseName);
        $result = mysqli_query($conn,$query);
        $value = mysqli_fetch_assoc($result);

        return $value[$column];
    }

    function GetExternalTableQueryCount($database,$table,$cond="")
    {
        $conn = GetConnection();
        $conn->select_db($database);
        $result = mysqli_query($conn,"SELECT Count(*) as count FROM ".$table." ".$cond);
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    function GetTable($table) //Returns a fully constructed table with headers
    {
        $html = "<table id='sqlTable' class='table".$table."'>
                    <tr>";
        //Get table headers
        $conn = GetConnection();
        $sql = "SHOW COLUMNS FROM ".$table;
        $res = $conn->query($sql);

        if($res!==false)
        {
            while($row=$res->fetch_assoc())
            {
                $html .= "<th>".$row['Field']."</th>";
            }
        }

        $html .= "</tr>";

        $sql = "SELECT * FROM ".$table;
        $res = $conn->query($sql);

        if($res!==false)
        {
            while($row=$res->fetch_assoc())
            {
                $html .= "<tr>";
                $sql2 = "SHOW COLUMNS FROM ".$table;
                $res2 = $conn->query($sql2);
                if($res!==false)
                {
                    while($row2=$res2->fetch_assoc())
                    {
                        $html .= "<td>".$row[$row2['Field']]."</td>";
                    }
                }
                $html .= "</tr>";
            }
        }

        $html .= "</table>";

        return $html;
    }

    function GetTableWithConditions($table,$conditions,$fieldsToIgnore="") //Returns a fully constructed table with headers, fieldsToIgnore separated by a comma
    {
        $html = "<table id='sqlTable' class='table".$table."'>
                    <tr>";
        //Get table headers
        $conn = GetConnection();
        $sql = "SHOW COLUMNS FROM ".$table;
        $res = $conn->query($sql);

        $fieldsToIgnoreArr = explode(",", $fieldsToIgnore);


        if($res!==false)
        {
            while($row=$res->fetch_assoc())
            {
                if(!in_array($row['Field'],$fieldsToIgnoreArr))
                    $html .= "<th>".$row['Field']."</th>";
            }
        }

        $html .= "</tr>";

        $sql = "SELECT * FROM ".$table . " WHERE " . $conditions;
        $res = $conn->query($sql);

        if($res!==false)
        {
            while($row=$res->fetch_assoc())
            {
                $html .= "<tr>";
                $sql2 = "SHOW COLUMNS FROM ".$table;
                $res2 = $conn->query($sql2);
                if($res!==false)
                {
                    while($row2=$res2->fetch_assoc())
                    {
                        if(!in_array($row2['Field'],$fieldsToIgnoreArr))
                        {
                            if($row2['Field']=="DayOfWeek")
                            {
                                $html .= "<td>".getDayOfWeekString($row[$row2['Field']])."</td>";
                            }
                            else
                            {
                                $html .= "<td>".$row[$row2['Field']]."</td>";
                            }
                        }
                            
                    }
                }
                $html .= "</tr>";
            }
        }

        $html .= "</table>";

        return $html;
    }

    

    function CheckIfTableContainsValue($table,$field,$value)
    {
        $con = GetConnection();
        $query = mysqli_query($con, "SELECT * FROM ".$table." WHERE ".$field."='".$value."'");

        if (!$query)
        {
            die('Error: ' . mysqli_error($con));
        }

        if(mysqli_num_rows($query) > 0){

            return true;

        }else{

            return false;

        }
    }

    function PrepareValue($value)
    {
        $con = GetConnection();
        return $con->real_escape_string($value);
    }

    function GenerateTaskPanels($conditions)
    {
        $con = GetConnection();
        $html = "";
        $sql = "SELECT * FROM Tasks WHERE ".$conditions;
        $res = $con->query($sql);

        if($res!==false)
        {
            $formID = "'addTask'";
            while($row=$res->fetch_assoc())
            {
                if($row["Repeat"]=="1")
                {
                    if($row["RepeatRate"]=="Weekly")
                    {
                        $html .= '  <div class="taskPanel" id="weekly">
                                        <label id="description"><i class="fas fa-sticky-note"></i>&nbsp;'.$row["Description"].'</label><br>
                                        <label id="repeat"><i class="fas fa-calendar"></i>&nbsp;Weekly - '.getDayOfWeekString($row["DayOfWeek"]).'</label><br>
                                        <label id="time"><i class="fas fa-clock"></i>&nbsp;'.$row["Hour"].'</label><br>';
                            
                    }
                    else
                    {
                        $html .= '  <div class="taskPanel" id="daily">
                                        <label id="description"><i class="fas fa-sticky-note"></i>&nbsp;'.$row["Description"].'</label><br>
                                        <label id="repeat"><i class="fas fa-calendar"></i>&nbsp;Daily</label><br>
                                        <label id="time"><i class="fas fa-clock"></i>&nbsp;'.$row["Hour"].'</label><br>';
                    }

                    $html.='            <div class="actions"><a id="'.$row["GUID"].'" onclick="ChangeFormToEdit('.$formID.',this.id);" href="#"><i class="fas fa-edit"></i></a>&nbsp;<a href="actions/delete_task.php?id='.$row["GUID"].'"><i class="fas fa-trash-alt"></i></a></div>
                                    </div><br>';
                }
                else
                {
                    $html .= '  <div class="taskPanel" id="noRepeat">
                                    <label id="description"><i class="fas fa-sticky-note"></i>&nbsp;'.$row["Description"].'</label><br>
                                    <label id="repeat"><i class="fas fa-calendar"></i>&nbsp;'.$row["Date"].'</label><br>
                                    <label id="time"><i class="fas fa-clock"></i>&nbsp;'.$row["Hour"].'</label><br>';
                    $html.='        <div class="actions"><a id="'.$row["GUID"].'" onclick="ChangeFormToEdit('.$formID.',this.id);" href="#"><i class="fas fa-edit"></i></a>&nbsp;<a href="actions/delete_task.php?id='.$row["GUID"].'"><i class="fas fa-trash-alt"></i></a></div>
                                </div><br>';
                }
            }
        }


        return $html;
    }
?>