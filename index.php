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
        <script src="http://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <?php HeaderImports(); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8"> 
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
                            <?php
                                if($loggedIn)
                                {
                            ?>
                                    <a class="nav-link" href="#"><?php echo $_COOKIE['username']; ?></a>
                                    <a class="nav-link" href="logout.php">Logout</a>
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
                <span class="lblEvents">Today's events:</span><br>
                <?php 
                    $date = date('Y-m-d');
                    $days = [
                        1 => 'Sunday',
                        2 => 'Monday',
                        3 => 'Tuesday',
                        4 => 'Wednesday',
                        5 => 'Thursday',
                        6 => 'Friday',
                        7 => 'Saturday'
                      ];
                    $dayOfWeek = $days[date('N')];

                    echo GetTableWithConditions("Tasks","UserGUID = '".GetTableValue("Users", "GUID", "WHERE Username='".$username."'")."' AND Date='".$date."' OR (RepeatRate='Weekly' AND DayOfWeek='".$dayOfWeek."')","ID,GUID,UserGUID"); 
                ?>
            </div>
            <footer class="page-footer footer container-fluid fixed-bottom">
                <span class="madeBy">Made by <a href="https://omegaleo.pt" targt="_blank"><img src="img/Logo.png"></a></span>
            </footer>
        </div>
    </body>
</html>