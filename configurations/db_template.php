//This file doesn't need the php starting tags because it'll be called from the functions.php file in the root folder

$host = "your database host";
$username = "your database username";
$password = "your database password";
$dbname = "your database name";

//Defining like this so it can be called from any part of the code
define("DBHost", $host);
define("DBUsername", $username);
define("DBPassword",$password);
define("DBName",$dbname);
define("DBPort",3306);