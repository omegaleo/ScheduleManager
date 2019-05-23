<?php
    include('functions.php');
    $loggedIn = false;
    if(isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
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
                    <a class="navbar-brand" href="index.php">Logo</a>
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
                                    <p class="nav-link"><?php echo $_SESSION['username']; ?></p>
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
                <h1 class="page-title title">Schedule Manager</h1><br>
                <span id="dateTime"></span>
            </div>
            <footer class="page-footer footer container-fluid fixed-bottom">
                <span class="madeBy">Made by <a href="https://omegaleo.pt" targt="_blank"><img src="img/Logo.png"></a></span>
            </footer>
        </div>
    </body>
</html>