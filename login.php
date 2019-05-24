<?php
    include('functions.php');
    $loggedIn = false;
    if(isset($_COOKIE['username']))
    {
        $username = $_COOKIE['username'];
        if($username!="")
        {
            $loggedIn = true;
            header("Location: index.php"); //User is logged in so redirect to index
        }
    }
?>
<html>
    <head>
        <script src="http://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <?php HeaderImports(); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8"> 
    </head>
    <body>
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
                                    <p class="nav-link"><?php echo $_COOKIE['username']; ?></p>
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
                <div class="page-title"><h1 class="title">Login</h1></div><br>
                <div class="tabControl">
                    <div class="tabs">
                        <button class="tab selected" id="Login" onclick="TabPage(this.id);">Login</button>
                        <button class="tab" id="Register" onclick="TabPage(this.id);">Register</button>
                    </div>
                    <div class="tabPages">
                        <div id="tPLogin" class="tabPage">
                                <form action="#" class="loginForm" method="POST">
                                    <input type="text" name="username" placeholder="Username"/><br>
                                    <input type="text" name="password" placeholder="Password"/><br>
                                    <input type="hidden" name="type" value="login"/>
                                    <input type="submit" value="Login"/>
                                </form>
                        </div>
                        <div id="tPRegister" class="tabPage hidden">
                                <form action="#" class="registerForm" method="POST">
                                    <input type="text" name="username" placeholder="Username"/><br>
                                    <input type="text" name="password" placeholder="Password"/><br>
                                    <input type="text" name="password" placeholder="Email"/><br>
                                    <input type="hidden" name="type" value="register"/>
                                    <input type="submit" value="Register"/>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="page-footer footer container-fluid fixed-bottom">
                <span class="madeBy">Made by <a href="https://omegaleo.pt" targt="_blank"><img src="img/Logo.png"></a></span>
            </footer>
        </div>
    </body>
</html>