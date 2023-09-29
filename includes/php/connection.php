<?php

/*  
    starts a session using the database because almost every page is using the 
    database in some way this should be the only php that needs session start
*/
session_start();

// will change to proper database once meaningful data is added
$server = 'deepblue.cs.camosun.bc.ca';
$user = 'ICS199Group02';
$pswd = '345678P';
$db='ICS199Group02_DB';

// connect to database
$dbc = mysqli_connect($server,$user,$pswd,$db);

if (!$dbc) {
    die ('MySQL Error:' . mysqli_connect_error());
}
 else {
     print "Connected to database " . $db . "<BR><BR>"; // print a message to indicate connection is live for testing purposes
 }



?>