<?php
//database connection configuration file + root path define

session_start();
 $conn = mysqli_connect("localhost", "maturitaoli2", "Oliver1810", "maturitaoli2");
if (!$conn) {
  die("Error connecting to database: ". mysqli_connect_error());
}


/*define("SERVER","localhost"); // väè¹inou býva server localhost
define("LOGIN","maturitaoli2"); // na localhoste to býva väè¹inou root
define("PASS","Oliver1810"); // va¹e heslo do databázy
define("DATABASE","maturitaoliver"); // názov databázy

// pripojenie do databázy
$dbc = mysql_connect(SERVER,LOGIN,PASS) or die('Pripojenie k serveru zlyhalo!');
mysql_select_db(DATABASE) or die('Nepodarilo sa oznaèi databázovú tabu¾ku!'); */


define ('ROOT_PATH', realpath(dirname(__FILE__)));
?>
