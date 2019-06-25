<?php
    include('functions.php');
    $loggedIn = false;
    if(isset($_COOKIE['username']))
    {
        $username = $_COOKIE['username'];
        if($username!="")
            $loggedIn = true;
    }
?>
<html>
    <head>
        
        <?php HeaderImports(); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <title>Schedule Manager</title> 
    </head>
    <body onload="startTime()">
        <div class="box">
            <header class="page-header header container-fluid">
                <nav class="navbar navbar-expand-md">
                    <a class="navbar-brand" href="index.php">Schedule Manager</a>
                    <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="main-navigation">
                        <ul class="navbar-nav">
                        <li class="nav-item">
                            <!--<button onclick="DarkModeToggle()">Dark Mode</button>-->
                            <div id="darkModeSwitch" class="toggle-btn" onclick="DarkModeToggle()">
                                <div class="inner-circle"><i id="darkModeIcon" class="fas fa-sun"></i></div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <?php
                                if($loggedIn)
                                {
                            ?>
                                    <a class="nav-link" href="#"><?php echo $_COOKIE['username']; ?></a>
                        </li>
                        <li class="nav-item">
                                    <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                            <?php
                                }
                                else
                                {
                            ?>
                                    <a class="nav-link" href="login.php">Login/Register</a>
                            <?php
                                }
                            ?>
                        </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <div class="page-content content container-fluid">
                <div class="page-title"><h1 class="title">Schedule Manager</h1></div><br>
                <span id="dateTime"></span>
                <?php
                    if(isset($_COOKIE['username']))
                    {
                ?>
                <a class="addTaskBtn" onclick="ToggleObjectActive('addTask');">Add Task</a><br>
                <span class="lblEvents">Today's events:</span><br>
                <?php 
                    $date = date('Y-m-d');
                    $dayOfWeek = date('w');
                    echo GetTableWithConditions("Tasks","UserGUID = '".GetTableValue("Users", "GUID", "WHERE Username='".$username."'")."' AND (Date='".$date."' OR (RepeatRate='Weekly' AND DayOfWeek='".$dayOfWeek."') OR (RepeatRate='Daily')) ORDER BY Hour ASC","ID,GUID,UserGUID"); 
                ?>
                <?php
                    }
                ?>
            </div>

            <form class="hidden" id="addTask" action="actions/add_task.php" method="POST">
                <a class="formCloseButton" onclick="ToggleObjectActive('addTask');">X</a><br>
                <h3>Add Task</h3>
                <input type="text" name="desc" placeholder="Description"/><br>
                <span>Repeat?</span>&nbsp;<input type="checkbox" name="repeat"/><br>
                <span>Repeat Rate:</span>&nbsp;<select name="repeatRate">
                    <option value="" selected></option>
                    <option value="Daily">Daily</option>
                    <option value="Weekly">Weekly</option>
                </select><br>
                <span>Date:</span>&nbsp;<input type="date" name="taskDate"/><br>
                <span>Day of the Week:</span>&nbsp;<select name="dayOfWeek">
                    <option value="" selected></option>
                    <option value="0">Sunday</option>
                    <option value="1">Monday</option>
                    <option value="2">Tuesday</option>
                    <option value="3">Wednesday</option>
                    <option value="4">Thursday</option>
                    <option value="5">Friday</option>
                    <option value="6">Saturday</option>
                </select><br>
                <span>Time:</span>&nbsp;<input type="time" name="time" name="hour"/>
                <input type="hidden" name="userGUID" value="<?php echo GetTableValue("Users", "GUID", "WHERE Username='".$username."'"); ?>"/><br>
                <input type="submit" value="Add"/>
            </form>
            <audio controls="controls" class="hidden" id="notification_player">
                <source src="media/notification.wav" type="audio/wav" />
                Your browser does not support the audio element.
            </audio>
            <footer class="page-footer footer container-fluid fixed-bottom">
                <span class="madeBy">Made by <a href="https://omegaleo.pt" targt="_blank"><img src="img/Logo.png"></a></span>
            </footer>
        </div>
    </body>
</html>